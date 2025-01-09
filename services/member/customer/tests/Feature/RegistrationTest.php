<?php

require_once __DIR__ . '/helpers.php';

it('registers a user successfully', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test-001@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], ['Accept' => 'application/json']);

    // Check if response content is empty JSON string
    $response->assertStatus(201);
    expect($response->getContent())->toBe('""');
    
    // Verify current user is authenticated
    $this->assertAuthenticated();

    // Delete the user after the test
    deleteUser('test-001@example.com');
});

it('fails to register with invalid data', function () {
    $response = $this->post('/register', [
        'name' => '',
        'email' => 'invalid-email',
        'password' => 'pass', // too short
        'password_confirmation' => 'different',
    ], ['Accept' => 'application/json']);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'name',
        'email',
        'password'
    ]);
});

it('fails to register without required fields', function () {
    $response = $this->post('/register', [], ['Accept' => 'application/json']);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors([
        'name',
        'email',
        'password'
    ]);
});

it('requires password confirmation to match', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test-002@example.com',
        'password' => 'password',
        'password_confirmation' => 'different',
    ], ['Accept' => 'application/json']);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['password']);
});

it('fails to register with a duplicate username', function () {
    // Register for the first time and log out
    $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test-003@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], ['Accept' => 'application/json']);

    $response = $this->post('/logout', [], ['Accept' => 'application/json']);

    /*
    // Dump mistake response content to a file
    $responseContent = [
        'status' => $response->status(),
        'headers' => $response->headers->all(),
        'content' => $response->getContent(),
    ];
    file_put_contents('tests/records/response_dump02.txt', print_r($responseContent, true));
    */

    // Register again with the same email
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test-003@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ], ['Accept' => 'application/json']);

    //dump($response);
    
    // Check if response status code is 422
    $response->assertStatus(422);
    // Check if JSON response contains email duplication error
    $response->assertJsonValidationErrors(['email']);

    deleteUser('test-003@example.com');
});

it('registers a user with remember token', function () {
    // Define request data with remember set to true
    $requestData = [
        'name' => 'Test User',
        'email' => 'test-006@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'remember' => true,
    ];

    $response = $this->post('/register', $requestData, ['Accept' => 'application/json']);

    // Check response status
    $response->assertStatus(201);
    
    // Check remember me cookie is present
    $this->assertNotNull($response->getCookie(Auth::getRecallerName()));
    
    // Verify user has remember token in database
    $user = Auth::user();
    $this->assertNotNull($user->remember_token);

    deleteUser('test-006@example.com');
});
