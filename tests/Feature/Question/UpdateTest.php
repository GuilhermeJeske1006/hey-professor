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

it('should make sure that only question with status dratf can be update', function () {

    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createBy')->create(['draft' => false]);
    $questionDraft    = Question::factory()->for($user, 'createBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft))->assertForbidden();
    put(route('question.update', $questionDraft), [
        'question' => 'New question',
    ])->assertRedirect();

});

it('should make sure that only the person who has created the question can update the question', function () {

    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question))->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), [
        'question' => 'New question',
    ])->assertRedirect();
});
