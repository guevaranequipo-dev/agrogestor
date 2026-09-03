<?php

use App\Models\User;

it('loads the fincas index page without errors', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/fincas')
        ->assertOk();
});
