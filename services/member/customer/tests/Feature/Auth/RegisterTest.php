<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeNotification;
use App\Listeners\CreateUserInformation;
use Illuminate\Support\Facades\Auth;


it('registers a user successfully', function () {
    $userData = [
        //'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->post('/register', $userData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'message',
        'user' => [
            //'name',
            'email',
        ],
    ]);

    expect(User::where('email', $userData['email'])->exists())->toBeTrue();
});

it('triggers registered event', function () {
    // Simulate Registered event
    Event::fake();

    // Create user
    $userData = [
        //'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->post('/register', $userData);

    // Verify Registered event was dispatched
    $user = User::where('email', $userData['email'])->first();
    Event::assertDispatched(Registered::class, function ($event) use ($user) {
        return $event->user->id === $user->id;
    });
});

it('sends welcome notification', function () {
    // Simulate WelcomeNotification notification
    Notification::fake();

    // Create user
    $userData = [
        //'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->post('/register', $userData);

    // Verify WelcomeNotification notification was sent
    $user = User::where('email', $userData['email'])->first();
    Notification::assertSentTo(
        [$user], 
        WelcomeNotification::class
    );
});

it('triggers listener after registration', function () {
    Event::fake();

    // Simulate user registration
    $user = User::factory()->create();

    // Trigger Registered event
    event(new Registered($user));

    // Verify CreateUserInformation listener was called
    Event::assertListening(
        Registered::class,
        CreateUserInformation::class
    );
});

it('creates empty user information after registration', function () {
    // Simulate user registration
    $user = User::factory()->create();

    // Trigger Registered event
    event(new Registered($user));

    // Verify an empty user information record is created in the user_information table
    $this->assertDatabaseHas('customer.user_information', [
        'email' => $user->email,
        'name' => null,
        'nickname' => null,
        'gender' => null,
        'date_of_birth' => null,
        'profile_picture' => null,
        'phone_number' => null,
        'address' => null,
        'occupation' => null,
    ]);
});

it('fails to register a user with invalid data', function () {
    $userData = [
        //'name' => fake()->name,
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

it('prevents a logged-in user from registering again', function () {
    // Create a registered and logged-in user
    $user = User::factory()->create();

    // Simulate user login
    Auth::login($user);

    // Attempt to register a new account
    $response = $this->post('/register', [
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    // Update redirect check
    $response->assertRedirect('/'); 
    $response->assertRedirect('/');
});

