<?php

require_once __DIR__ . '/helpers.php';

use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

test('verification notification is sent', function () {
    
    Notification::fake();

    $user = createUnverifiedUser();

    // Test with logged-in user
    $verifyResponse = $this->actingAs($user)->postJson('/email/verification-notification'); 
    
    $verifyResponse->assertStatus(202);
    expect($verifyResponse->getContent())->toBe('""');

    //$user->sendEmailVerificationNotification(); 

    // Check if VerifyEmail notification was sent
    Notification::assertSentTo($user, VerifyEmail::class);

    deleteUser('testuser@example.com');
    
    /*
    // Check if the log file contains verification email notification records
    $logContent = File::get(storage_path('logs/laravel.log'));
    $this->assertStringContainsString('VerifyEmail', $logContent);

    // Create a temporary log channel
    $tempLogChannel = new Logger('tempLogChannel');
    $tempLogChannel->pushHandler(new StreamHandler(storage_path('mails/temp_lara.log'), Logger::INFO));
    // Log using the temporary log channel
    $tempLogChannel->info('Log Content: ' . $logContent);
    
    // Optional: Output log content to view details
    //Log::info('Log Content: ' . $logContent);
    */   
});


use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

test('email verification', function () {

    $user = createUnverifiedUser();

    // Generate verification URL
    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        Carbon::now()->addMinutes(60),
        ['id' => $user->id, 'hash' => sha1($user->getEmailForVerification())]
    );

    // Display URL in terminal
    //echo "Verification URL: " . $verificationUrl . "\n";

    // Simulate clicking the verification URL
    $response = $this->actingAs($user)->getJson($verificationUrl);

    // Confirm response status is 204
    $response->assertStatus(204);
    expect($response->getContent())->toBe('');

    // Confirm user's email has been marked as verified
    $this->assertTrue($user->fresh()->hasVerifiedEmail());

    deleteUser('testuser@example.com');
});



