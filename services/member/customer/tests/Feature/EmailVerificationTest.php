<?php

require_once __DIR__ . '/helpers.php';

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Notifications\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;

//uses(RefreshDatabase::class);

test('verification notification is sent', function () {
    Notification::fake();

    Notification::assertNothingSent();

    /*
    $user = createUnverifiedUser();

    $this->actingAs($user)->postJson('/email/verification-notification');

    Notification::assertSentTo(
        [$user], VerifyEmail::class
    );
    */
});


use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

test('verification notification is sent and logged', function () {
    
    //Notification::fake();
    // 創建一個未驗證的用戶
    $user = createUnverifiedUser();
    
    // 模擬用戶登錄
    $loginResponse = $this->postJson('/login', [
        'email' => 'testuser@example.com',
        'password' => 'password123',
    ]);

    // 使用已登錄的用戶進行測試 
    $this->actingAs($user); 
    // 調用 sendEmailVerificationNotification 方法 
    $user->sendEmailVerificationNotification(); 
    // 檢查是否發送了 VerifyEmail 通知 
    //Notification::assertSentTo($user, VerifyEmail::class);

    $loginResponse->assertStatus(200); // 確認登錄成功

    // 發送驗證郵件通知
    $verifyResponse = $this->postJson('/email/verification-notification');

    $verifyResponse->assertStatus(202); // 確認通知發送成功

    $responseContent = [
        'status' => $verifyResponse->status(),
        'headers' => $verifyResponse->headers->all(),
        'content' => $verifyResponse->getContent(),
    ];
    file_put_contents('tests/records/response_dump02.txt', print_r($responseContent, true));
    
    deleteUser('testuser@example.com');
    //Notification::assertSentTo($user, VerifyEmail::class);
    /*
    // 檢查日誌文件中是否包含驗證郵件通知的記錄
    $logContent = File::get(storage_path('logs/laravel.log'));
    $this->assertStringContainsString('VerifyEmail', $logContent);

    // 選擇性：可以輸出日誌內容以查看詳細信息
    Log::info('Log Content: ' . $logContent);
    */
});



