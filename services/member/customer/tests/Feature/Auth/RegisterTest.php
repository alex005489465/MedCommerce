<?php

use App\Models\User;


it('registers a user successfully', function () {
    $userData = [
        'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post('/register', $userData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'message',
        'user' => [
            'name',
            'email',
        ],
    ]);

    expect(User::where('email', $userData['email'])->exists())->toBeTrue();
});

it('fails to register a user with invalid data', function () {
    $userData = [
        'name' => fake()->name,
        // Missing email to trigger validation error
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post('/register', $userData);

    $response->assertStatus(422);
    $response->assertJsonStructure([
        'errors' => [
            'email',
        ],
    ]);
});
