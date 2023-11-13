<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it('should be able to update a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $user->id]);

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'Updated Question?',
    ])->assertRedirect(route('question.index'));

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

it('should be able to update a new question bigger tha 255 characteres ', function () {

    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createBy')->create(['draft' => true]);

    actingAs($user);

    // Act :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assert :: verificar
    $request->assertRedirect();

    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should check if ends with question mark ?', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createBy')->create(['draft' => true]);
    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that is a question? It is missing the question mark in the end.',
    ]);

});

it('should have at least 10 characters', function () {

    // Arrange :: preparar
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createBy')->create(['draft' => true]);
    actingAs($user);

    // Act :: agir
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    // Assert :: verificar
    $request->assertSessionHasErrors([
        'question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question']),
    ]);

});
