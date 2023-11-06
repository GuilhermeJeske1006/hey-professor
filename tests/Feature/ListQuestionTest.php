<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('Should list all the questions', function () {

    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(5)->create();

    // Act :: agir
    $response = get(route('dashboard'));

    // Assert :: verificar
    $response->assertStatus(200);

    /** @var Question $q */

    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
