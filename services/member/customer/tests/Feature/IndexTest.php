<?php

test('root route returns welcome message', function () {
    $response = $this->get('/', ['Accept' => 'application/json']);

    $response->assertStatus(200);

    $response->assertJson([
        'message' => 'welcome to Med shop',
    ]);
});

test('root route returns error if JSON not accepted', function () {
    $response = $this->get('/');

    $response->assertStatus(406);

    $response->assertJson([
        'error' => 'This endpoint only accepts JSON requests.',
    ]);
});
