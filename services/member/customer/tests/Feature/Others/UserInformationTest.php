<?php

use App\Models\User;
use App\Models\UserInformation;

it('successfully retrieves user information', function () {
    // Create a test user and corresponding user_information data
    $user = User::factory()->create();
    UserInformation::factory()->create(['email' => $user->email]);

    // Simulate user login
    $this->actingAs($user);

    // Request the user-information route
    $response = $this->get('/user-information');

    // Verify successful data retrieval
    $response->assertStatus(200);
    $response->assertJson([
        'email' => $user->email,
    ]);
});

it('fails to retrieve user information if not exists', function () {
    // Create a test user but do not create corresponding user_information data
    $user = User::factory()->create();

    // Simulate user login
    $this->actingAs($user);

    // Request the user-information route
    $response = $this->get('/user-information');

    // Verify data retrieval failure
    $response->assertStatus(404);
    $response->assertJson([
        'error' => 'User information not found.',
    ]);
});

it('fails to retrieve user information if not authenticated', function () {
    // Create a test user and corresponding user_information data
    $user = User::factory()->create();
    UserInformation::factory()->create(['email' => $user->email]);

    // Do not simulate user login

    // Request the user-information route
    $response = $this->get('/user-information');

    // Verify data retrieval failure, should return 403 status code and JSON message
    $response->assertStatus(403);
    $response->assertJson([
        'message' => 'Please log in to proceed',
    ]);
});
