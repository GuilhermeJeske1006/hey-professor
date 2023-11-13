<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to update a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect();

    $question->refresh();

    expect($question)
        ->question->toBe('Updated Question?');
});
