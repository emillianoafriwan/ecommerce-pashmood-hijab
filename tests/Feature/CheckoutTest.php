<?php

use App\Models\User;

test('checkout page redirects to cart', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/checkout');

    $response->assertRedirect(route('cart.index'));
});

test('cart page displays successfully when cart has items', function () {
    $user = User::factory()->create();

    // Buat data kategori
    $category = \App\Models\Category::create([
        'name' => 'Pashmina Silk Kategori',
        'slug' => 'pashmina-silk-kategori',
    ]);

    // Buat data produk
    $product = \App\Models\Product::create([
        'name' => 'Pashmina Silk',
        'slug' => 'pashmina-silk',
        'category_id' => $category->id,
        'price' => 50000,
        'image_path' => 'products/silk.jpg',
        'description' => 'Pashmina Silk satin mewah',
    ]);

    // Buat variasi produk
    $variation = \App\Models\ProductVariation::create([
        'product_id' => $product->id,
        'color' => 'Navy',
    ]);

    // Buat item keranjang di database agar disinkronkan oleh middleware SyncCartSession
    \App\Models\CartItem::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
        'quantity' => 2,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/cart');

    $response->assertStatus(200);
    $response->assertSee('Pashmina Silk');
});

test('checkout fails when no items are selected', function () {
    $user = User::factory()->create();

    // Create Category, Product, Variation, CartItem
    $category = \App\Models\Category::create(['name' => 'Voal Kategori', 'slug' => 'voal-kategori']);
    $product = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Pashmina Voal',
        'slug' => 'pashmina-voal',
        'price' => 45000,
        'image_path' => 'products/voal.jpg',
    ]);
    $variation = \App\Models\ProductVariation::create(['product_id' => $product->id, 'color' => 'Black']);

    \App\Models\CartItem::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
        'quantity' => 1,
    ]);

    // Send post without items parameter
    $response = $this
        ->actingAs($user)
        ->post('/checkout', [
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'village' => 'Selong',
            'detail_address' => 'Jl. Sudirman No. 12',
            'phone' => '0812345678',
            'courier' => 'JNE Express',
        ]);

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('error', 'Keranjang kosong atau produk belum dipilih!');
});

test('checkout processes only selected items', function () {
    $user = User::factory()->create();

    $category = \App\Models\Category::create(['name' => 'Voal Kategori', 'slug' => 'voal-kategori']);
    $product = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Pashmina Voal',
        'slug' => 'pashmina-voal',
        'price' => 45000,
        'image_path' => 'products/voal.jpg',
    ]);

    $v1 = \App\Models\ProductVariation::create(['product_id' => $product->id, 'color' => 'Black']);
    $v2 = \App\Models\ProductVariation::create(['product_id' => $product->id, 'color' => 'Red']);

    // Create 2 items in database
    $c1 = \App\Models\CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'product_variation_id' => $v1->id, 'quantity' => 1]);
    $c2 = \App\Models\CartItem::create(['user_id' => $user->id, 'product_id' => $product->id, 'product_variation_id' => $v2->id, 'quantity' => 2]);

    // Checkout only c1
    $response = $this
        ->actingAs($user)
        ->post('/checkout', [
            'province' => 'DKI Jakarta',
            'city' => 'Jakarta Selatan',
            'district' => 'Kebayoran Baru',
            'village' => 'Selong',
            'detail_address' => 'Jl. Sudirman No. 12',
            'phone' => '0812345678',
            'courier' => 'JNE Express',
            'items' => [$product->id . '_' . $v1->id], // Only c1 selected
        ]);

    // Assert redirect to order detail page
    $order = \App\Models\Order::first();
    expect($order)->not->toBeNull();
    $response->assertRedirect(route('order.detail', $order->id));

    // Verify order items: only v1 should be present
    expect($order->orderItems()->count())->toBe(1);
    expect($order->orderItems()->first()->variation_id)->toBe($v1->id);

    // Verify CartItem database state: c1 should be deleted, c2 should still exist
    expect(\App\Models\CartItem::where('id', $c1->id)->exists())->toBeFalse();
    expect(\App\Models\CartItem::where('id', $c2->id)->exists())->toBeTrue();
});

test('viewing order detail as admin marks order as read', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create();

    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 45000,
        'status' => 'pending',
        'address' => 'Test Address',
        'province' => 'Prov',
        'city' => 'City',
        'district' => 'Dist',
        'village' => 'Vill',
        'detail_address' => 'Detail',
        'phone' => '0812345',
        'courier' => 'JNE Express',
        'admin_read' => false, // Start as unread
    ]);

    expect($order->admin_read)->toBeFalse();

    // Access order details as admin
    $response = $this
        ->actingAs($admin)
        ->get(route('admin.order.detail', $order->id));

    $response->assertOk();

    // Verify database state: order admin_read is now true
    $order->refresh();
    expect($order->admin_read)->toBeTrue();
});

test('buyer dashboard displays successfully with metrics and recent orders', function () {
    $user = User::factory()->create(['role' => 'user']);
    
    // Create a Category, Product, Variation, and an Order for the user
    $category = \App\Models\Category::create(['name' => 'Silk Cat', 'slug' => 'silk-cat']);
    $product = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Pashmina Premium',
        'slug' => 'pashmina-premium',
        'price' => 60000,
        'image_path' => 'products/premium.jpg',
    ]);
    $variation = \App\Models\ProductVariation::create(['product_id' => $product->id, 'color' => 'Mocca']);
    
    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total_price' => 60000,
        'status' => 'completed',
        'phone' => '0812345678',
        'province' => 'Jawa Barat',
        'city' => 'Bandung',
        'district' => 'Coblong',
        'village' => 'Dago',
        'detail_address' => 'Jl. Dago No. 1',
        'courier' => 'JNE Express',
    ]);
    
    \App\Models\OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'variation_id' => $variation->id,
        'quantity' => 1,
        'price' => 60000,
    ]);

    $response = $this
        ->actingAs($user)
        ->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Total Belanja');
    $response->assertSee('Semua Pesanan');
    $response->assertSee('Rp 60.000');
});

test('inactive products are not visible in store catalog list', function () {
    $category = \App\Models\Category::create(['name' => 'Active Cat', 'slug' => 'active-cat']);
    
    $activeProduct = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Active Pashmina',
        'slug' => 'active-pashmina',
        'price' => 50000,
        'image_path' => 'products/active.jpg',
        'is_active' => true,
    ]);

    $inactiveProduct = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Inactive Pashmina',
        'slug' => 'inactive-pashmina',
        'price' => 50000,
        'image_path' => 'products/inactive.jpg',
        'is_active' => false,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Active Pashmina');
    $response->assertDontSee('Inactive Pashmina');
});

test('inactive product details page shows inactive banner and disables pre-order', function () {
    $category = \App\Models\Category::create(['name' => 'Active Cat', 'slug' => 'active-cat']);
    
    $inactiveProduct = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Deactivated Pashmina',
        'slug' => 'deactivated-pashmina',
        'price' => 50000,
        'image_path' => 'products/inactive.jpg',
        'is_active' => false,
    ]);

    $response = $this->get(route('product.show', $inactiveProduct->id));

    $response->assertStatus(200);
    $response->assertSee('Produk ini sedang dinonaktifkan dan tidak tersedia untuk dipesan.');
    $response->assertDontSee('Amankan Slot Pre-Order');
});

test('adding inactive product to cart is rejected and redirects to shop index', function () {
    $user = User::factory()->create();
    $category = \App\Models\Category::create(['name' => 'Active Cat', 'slug' => 'active-cat']);
    
    $inactiveProduct = \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Deactivated Pashmina',
        'slug' => 'deactivated-pashmina',
        'price' => 50000,
        'image_path' => 'products/inactive.jpg',
        'is_active' => false,
    ]);
    
    $variation = \App\Models\ProductVariation::create([
        'product_id' => $inactiveProduct->id,
        'color' => 'Navy',
    ]);

    $response = $this
        ->actingAs($user)
        ->post(route('cart.add', $inactiveProduct->id), [
            'variation_id' => $variation->id,
            'quantity' => 1,
        ]);

    $response->assertRedirect(route('shop.index'));
    $response->assertSessionHas('error', 'Produk ini sudah tidak aktif/dijual.');
});

test('admin can filter products by active and inactive status', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $category = \App\Models\Category::create(['name' => 'Active Cat', 'slug' => 'active-cat']);
    
    \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Active Product X',
        'slug' => 'active-product-x',
        'price' => 50000,
        'image_path' => 'products/active.jpg',
        'is_active' => true,
    ]);

    \App\Models\Product::create([
        'category_id' => $category->id,
        'name' => 'Inactive Product Y',
        'slug' => 'inactive-product-y',
        'price' => 50000,
        'image_path' => 'products/inactive.jpg',
        'is_active' => false,
    ]);

    // Query active only
    $response = $this
        ->actingAs($admin)
        ->get(route('products.index', ['status' => 'active']));
    $response->assertStatus(200);
    $response->assertSee('Active Product X');
    $response->assertDontSee('Inactive Product Y');

    // Query inactive only
    $response = $this
        ->actingAs($admin)
        ->get(route('products.index', ['status' => 'inactive']));
    $response->assertStatus(200);
    $response->assertSee('Inactive Product Y');
    $response->assertDontSee('Active Product X');
});


