<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;

it('can soft delete a variation that has orders, and old orders still work', function () {
    // Create admin user
    $admin = User::factory()->create(['role' => 'admin']);

    // Create Category, Product, Variation
    $category = Category::create(['name' => 'Test Cat', 'slug' => 'test-cat']);
    $product = Product::create([
        'category_id' => $category->id,
        'name' => 'Test Product',
        'slug' => 'test-product',
        'price' => 10000,
        'description' => 'Test Desc',
    ]);
    
    $variation = ProductVariation::create([
        'product_id' => $product->id,
        'color' => 'Red',
    ]);

    // Create Order and OrderItem referencing the variation
    $user = User::factory()->create();
    $order = Order::create([
        'user_id' => $user->id,
        'total_price' => 10000,
        'status' => 'pending',
        'phone' => '12345678',
        'province' => 'Province',
        'city' => 'City',
        'district' => 'District',
        'village' => 'Village',
        'detail_address' => 'Detail Address',
        'courier' => 'JNE',
    ]);

    $orderItem = OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'variation_id' => $variation->id,
        'quantity' => 1,
        'price' => 10000,
    ]);

    // Create a CartItem for this variation
    $cartItem = CartItem::create([
        'user_id' => $user->id,
        'product_id' => $product->id,
        'product_variation_id' => $variation->id,
        'quantity' => 1,
    ]);

    // Make sure variation and cart item exist
    expect(ProductVariation::where('id', $variation->id)->exists())->toBeTrue();
    expect(CartItem::where('id', $cartItem->id)->exists())->toBeTrue();

    // Now soft delete the variation
    $variation->delete();

    // Assert that the variation is soft deleted (not found in normal query but found in withTrashed)
    expect(ProductVariation::where('id', $variation->id)->exists())->toBeFalse();
    expect(ProductVariation::withTrashed()->where('id', $variation->id)->exists())->toBeTrue();

    // Assert that the OrderItem's variation relationship still works (using withTrashed)
    $freshOrderItem = OrderItem::find($orderItem->id);
    expect($freshOrderItem->variation)->not->toBeNull();
    expect($freshOrderItem->variation->color)->toBe('Red');

    // Assert that the CartItem was automatically deleted
    expect(CartItem::where('id', $cartItem->id)->exists())->toBeFalse();
});
