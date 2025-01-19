<?php

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;

it('successfully retrieves user information', function () {
    // Create a test user and corresponding user_information data
    $user = User::factory()->create();
    $userInformation = UserInformation::factory()->create(['email' => $user->email]);

    // Simulate user login
    $this->actingAs($user);

    // Request the user-information route
    $response = $this->get('/user-information');

    // Verify successful data retrieval
    $response->assertStatus(200);
    
    // Verify the returned JSON data includes all fields
    $response->assertJson([
        'email' => $userInformation->email,
        'name' => $userInformation->name,
        'nickname' => $userInformation->nickname,
        'gender' => $userInformation->gender,
        'date_of_birth' => $userInformation->date_of_birth->toISOString(),
        'profile_picture' => $userInformation->profile_picture,
        'phone_number' => $userInformation->phone_number,
        'address' => $userInformation->address,
        'occupation' => $userInformation->occupation,
    ]);
});

it('formatUserInformation returns empty values for null attributes', function () {
    
    $userData = [
        'email' => fake()->safeEmail,
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $this->post('/register', $userData);
    Auth::login(User::where('email', $userData['email'])->first());

    $response = $this->get('/user-information');
    $response->assertStatus(200);
    $response->assertJson([
        'email' => $userData['email'],
        'name' => '',
        'nickname' => '',
        'gender' => '',
        'date_of_birth' => '',
        'profile_picture' => '',
        'phone_number' => '',
        'address' => '',
        'occupation' => '',
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

it('updates user information successfully', function () {
    // 建立使用者和使用者資訊
    $user = User::factory()->create();
    UserInformation::factory()->create(['email' => $user->email]);

    // 模擬使用者登入
    $this->actingAs($user);

    // 模擬更新請求
    $response = $this->post('/user-information', [
        'email' => $user->email, // 確保包含 email 字段
        'name' => 'New Name',
        'address' => 'New Address',
    ]);

    // 檢查回傳狀態碼 200
    $response->assertStatus(200);

    // 檢查回傳的 JSON 資訊
    $response->assertJsonFragment([
        'email' => $user->email,
        'name' => 'New Name',
        'address' => 'New Address',
    ]);

    // 確認數據庫中使用者資訊已更新
    $this->assertDatabaseHas('customer.user_information', [
        'email' => $user->email,
        'name' => 'New Name',
        'address' => 'New Address',
    ]);
});


it('returns 403 when email does not match', function () {
    $user = User::factory()->create();
    UserInformation::factory()->create(['email' => $user->email]);

    Auth::login($user);
    $response = $this->post('/user-information', [
        'email' => 'wrong@example.com',
        'name' => 'New Name',
        'address' => 'New Address',
    ]);

    $response->assertStatus(403);
    $response->assertJson(['error' => 'Email mismatch. Update failed.']);
});

it('returns 404 when user information not found', function () {
    $user = User::factory()->create();
    Auth::login($user);

    $response = $this->post('/user-information', [
        'email' => $user->email,
        'name' => 'New Name',
        'address' => 'New Address',
    ]);

    $response->assertStatus(404);
    $response->assertJson(['error' => 'User information not found.']);
});

