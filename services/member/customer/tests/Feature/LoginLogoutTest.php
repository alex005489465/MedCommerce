<?php

require_once __DIR__ . '/helpers.php';

it('login successfully with correct JSON request', function () {
    $user = createUser();

    $response = $this->postJson('/login', [
        'email' => 'testuser@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200);
    expect($response->getContent())->toBe('{"two_factor":false}');
    $this->assertAuthenticatedAs($user);

    deleteUser('testuser@example.com');
});

it('fails to login with incorrect password', function () {
    createUser();

    $response = $this->postJson('/login', [
        'email' => 'testuser@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(422);
    $this->assertGuest();

    deleteUser('testuser@example.com');
});

it('fails to login with unregistered email', function () {
    createUser();

    $response = $this->postJson('/login', [
        'email' => 'unregistered@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(422);
    $this->assertGuest();

    deleteUser('testuser@example.com');
});

it('login and remembers the user', function () {
    $user = createUser();

    $response = $this->postJson('/login', [
        'email' => 'testuser@example.com',
        'password' => 'password123',
        'remember' => true,
    ]);

    $response->assertStatus(200);
    $this->assertAuthenticatedAs($user);

    // Check remember me cookie is present
    $this->assertNotNull($response->getCookie(Auth::getRecallerName()));

    deleteUser('testuser@example.com');
});

it('logout successfully', function () {
    $user = createUser();

    $this->actingAs($user);

    $response = $this->postJson('/logout');

    $response->assertStatus(204);
    expect($response->getContent())->toBe('');
    $this->assertGuest();

    deleteUser('testuser@example.com');
});




