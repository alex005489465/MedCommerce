<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WelcomeNotification;


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

it('triggers registered event', function () {
    // 模擬 Registered 事件
    Event::fake();

    // 創建用戶
    $userData = [
        'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->post('/register', $userData);

    // 確認 Registered 事件被調度
    $user = User::where('email', $userData['email'])->first();
    Event::assertDispatched(Registered::class, function ($event) use ($user) {
        return $event->user->id === $user->id;
    });
});

it('sends welcome notification', function () {
    // 模擬 WelcomeNotification 通知
    Notification::fake();

    // 創建用戶
    $userData = [
        'name' => fake()->name,
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $this->post('/register', $userData);

    // 確認 WelcomeNotification 通知被發送
    $user = User::where('email', $userData['email'])->first();
    Notification::assertSentTo(
        [$user], 
        WelcomeNotification::class
    );
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
