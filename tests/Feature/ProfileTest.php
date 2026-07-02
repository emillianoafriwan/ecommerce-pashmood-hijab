<?php

use App\Models\User;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $user->refresh();

    $this->assertSame('Test User', $user->name);
    $this->assertSame('test@example.com', $user->email);
    $this->assertNull($user->email_verified_at);
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile');

    $this->assertNotNull($user->refresh()->email_verified_at);
});

test('user can delete their account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->delete('/profile', [
            'password' => 'password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/');

    $this->assertGuest();
    $this->assertNull($user->fresh());
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->delete('/profile', [
            'password' => 'wrong-password',
        ]);

    $response
        ->assertSessionHasErrorsIn('userDeletion', 'password')
        ->assertRedirect('/profile');

    $this->assertNotNull($user->fresh());
});

test('profile address validation fails when some address fields are filled but detail address is empty', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'province' => 'DKI Jakarta',
            'province_code' => '31',
            'city' => 'Jakarta Selatan',
            'city_code' => '3174',
            'district' => 'Kebayoran Baru',
            'district_code' => '317401',
            'village' => 'Selong',
            'village_code' => '3174011001',
            'detail_address' => '', // empty!
        ]);

    $response->assertSessionHasErrors(['detail_address']);
});

test('profile address validation passes when all address fields are filled', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->patch('/profile', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'province' => 'DKI Jakarta',
            'province_code' => '31',
            'city' => 'Jakarta Selatan',
            'city_code' => '3174',
            'district' => 'Kebayoran Baru',
            'district_code' => '317401',
            'village' => 'Selong',
            'village_code' => '3174011001',
            'detail_address' => 'Jl. Jend. Sudirman Kav. 21',
        ]);

    $response->assertSessionHasNoErrors();
    $user->refresh();
    $this->assertSame('DKI Jakarta', $user->province);
    $this->assertSame('Jl. Jend. Sudirman Kav. 21', $user->detail_address);
});

test('user isProfileComplete correctly identifies incomplete and complete profile status', function () {
    $user = User::factory()->create();
    
    // Brand new user should not have complete profile
    $this->assertFalse($user->isProfileComplete());

    // Fill only phone number
    $user->phone = '081234567890';
    $this->assertFalse($user->isProfileComplete());

    // Fill all address components
    $user->province = 'DKI Jakarta';
    $user->city = 'Jakarta Selatan';
    $user->district = 'Kebayoran Baru';
    $user->village = 'Selong';
    $user->detail_address = 'Jl. Jend. Sudirman Kav. 21';
    
    // Now it should be complete
    $this->assertTrue($user->isProfileComplete());
});

