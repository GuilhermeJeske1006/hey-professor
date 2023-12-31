<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete, get};

it('should be able to destroy a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => false, 'created_by' => $user->id]);

    actingAs($user);

    delete(route('question.destroy', $question))
        ->assertRedirect();

    assertDatabaseMissing('questions', ['id' => $question->id]);
});

it('should make sure that only the person who has created the question can destroy the question', function () {

    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => false, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);

    delete(route('question.destroy', $question))
        ->assertForbidden();

    actingAs($rightUser);

    delete(route('question.destroy', $question))
        ->assertRedirect();
});

it('should make sure that only the person who has created the question can edit the question', function () {

    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    get(route('question.edit', $question))->assertForbidden();

    actingAs($rightUser);
    get(route('question.edit', $question))->assertSuccessful();
});
