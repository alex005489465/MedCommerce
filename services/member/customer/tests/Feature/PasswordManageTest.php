<?php

use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Mail;

it('can request a password reset link', function () {
    
    Notification::fake();

    $user = createUser();

    // request a password reset link
    $response = $this->postJson('/forgot-password', [
        'email' => $user->email,
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'We have emailed your password reset link.',
    ]);
    $response->assertSessionHasNoErrors();

    Notification::assertSentTo($user, ResetPassword::class);

    // request a password reset link again
    $againresponse = $this->postJson('/forgot-password', [
        'email' => $user->email,
    ]);
    $againresponse->assertStatus(422);
    $againresponse->assertJson([
        'message' => 'Please wait before retrying.',
        'errors' => [
            'email' => ['Please wait before retrying.'],
        ],
    ]);

    Notification::assertSentTo($user, ResetPassword::class);

    deleteUser('testuser@example.com');
});


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

it('can reset the password with valid token', function () {
    $user = createUser();

    // Simulate user requesting password reset
    $token = Password::createToken($user);

    $response = $this->postJson('/reset-password', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ]);

    $response->assertStatus(200);
    $response->assertJson([
        'message' => 'Your password has been reset.',
    ]);

    // Check if the password has been updated
    $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));

    deleteUser('testuser@example.com');
});

it('fails to reset the password with invalid token', function () {
    $user = createUser();

    // Use an invalid token to test
    $token = Password::createToken($user);
    $invalidToken = 'invalid-token';

    $response = $this->postJson('/reset-password', [
        'token' => $invalidToken,
        'email' => $user->email,
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword',
    ]);

    $response->assertStatus(422);
    $response->assertJson([
        'message' => 'This password reset token is invalid.',
        'errors' => [
            'email' => ['This password reset token is invalid.'],
        ],
    ]);

    // Check if the password has not been updated
    $this->assertFalse(Hash::check('newpassword', $user->fresh()->password));

    deleteUser('testuser@example.com');
});


