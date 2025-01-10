<?php

use Illuminate\Support\Facades\Hash;

it('can update the user password', function () {
    $user = createUser();

    $this->actingAs($user);

    $response = $this->putJson(route('user-password.update'), [
        'current_password' => 'password123',
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ]);

    $response->assertStatus(200);
    expect($response->getContent())->toBe('""');

    // Check if the password has been updated
    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));

    deleteUser('testuser@example.com');
});

it('can update the user profile information', function () {
    $user = createUser();

    $this->actingAs($user);

    $response = $this->putJson(route('user-profile-information.update'), [
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

    $response->assertStatus(200);
    expect($response->getContent())->toBe('""');

    // Check if the user profile information has been updated
    $this->assertEquals('New Name', $user->fresh()->name);
    $this->assertEquals('new@example.com', $user->fresh()->email);

    deleteUser('new@example.com');
});

