<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to search a question by test', function () {

    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    Question::factory()->create(['something else?']);
    Question::factory()->create(['question' => 'My question is?']);

    // Act :: agir
    $response = get(route('dashboard', ['search' => 'question']));

    // Assert :: verificar
    $response->assertStatus(200);

    $response->assertDontSee('something else?');
    $response->assertSee('My question is?');
});
