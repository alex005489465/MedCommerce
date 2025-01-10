<?php

it('can confirm the user password', function () {
    $user = createUser();

    $this->actingAs($user);

    $response = $this->postJson(route('password.confirm.store'), [
        'password' => 'password123',
    ]);

    $response->assertStatus(201);
    expect($response->getContent())->toBe('""');

    deleteUser('testuser@example.com');
});


it('can check the password confirmation status', function () {
    $user = createUser();

    $this->actingAs($user);

    $this->postJson(route('password.confirm.store'), [
        'password' => 'password123',
    ]);
    $response = $this->getJson(route('password.confirmation'));

    $response->assertStatus(200);
    $response->assertJson([
        'confirmed' => true,
    ]);

    deleteUser('testuser@example.com');
});

