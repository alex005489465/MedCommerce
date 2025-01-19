<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

it('logs in a user successfully', function () {
    // First, create a user
    $user = User::create([
        //'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => Hash::make('password'),
    ]);

    $loginData = [
        'email' => $user->email,
        'password' => 'password',
    ];

    // Attempt to log in
    $response = $this->post('/login', $loginData);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'message',
        'user' => [
            //'name',
            'email',
        ],
    ]);
});

it('fails to log in a user with invalid credentials', function () {
    $loginData = [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ];

    // Attempt to log in with invalid credentials
    $response = $this->post('/login', $loginData);

    $response->assertStatus(401);
    $response->assertJson([
        'message' => 'Invalid credentials',
    ]);
});

it('fails to log in a user with invalid data', function () {
    $loginData = [
        'email' => 'invalid-email', // Invalid email format
        'password' => 'short', // Password too short
    ];

    // Attempt to log in with invalid data
    $response = $this->post('/login', $loginData);

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'errors' => [
            'email',
            'password',
        ],
    ]);
});

it('prevents a logged-in user from logging in again', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $response = $this->postJson('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(302);
    $response->assertRedirect('/');
});

it('logs out a user successfully', function () {
    // First, create a user and log in
    $user = User::create([
        //'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    // Attempt to log out
    $response = $this->post('/logout');

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Logged out successfully',
    ]);
});
