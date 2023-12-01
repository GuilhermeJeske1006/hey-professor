<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, assertNotSoftDeleted, assertSoftDeleted, delete, patch, put};

it('should be able to archive a question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => false, 'created_by' => $user->id]);

    actingAs($user);

    patch(route('question.archive', $question))
        ->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->not->toBeNull();
});

it('should be able to restore an archive question', function () {

    $user = User::factory()->create();

    $question = Question::factory()->create(['draft' => false, 'created_by' => $user->id]);

    actingAs($user);

    patch(route('question.restore', $question))
        ->assertRedirect();

    assertNotSoftDeleted('questions', ['id' => $question->id]);

    expect($question)
        ->refresh()
        ->deleted_at->toBeNull();
});
