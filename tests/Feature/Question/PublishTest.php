<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

test('should be able to publish a question', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->create(['draft' => false]);

    actingAs($user);

    put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();

    expect($question)->draft->toBeFalse();
});
