<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Create a test user with the given email and password
 */
function createUser($email = 'testuser@example.com', $password = 'password123')
{
    return User::factory()->create([
        'email' => $email,
        'password' => bcrypt($password),
    ]);
};

/**
 * Create a test unverified user with the given email and password
 */
function createUnverifiedUser($email = 'testuser@example.com', $password = 'password123')
{
    return User::factory()->unverified()->create([
        'email' => $email,
        'password' => bcrypt($password),
    ]);
}

/**
 * Delete a user with the given email
 */
function deleteUser($email)
{
    $user = User::where('email', $email)->first();

    if ($user) {
        $user->delete();
    }

    return $user;
};
