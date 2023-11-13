<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

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

it('should paginate the result', function () {

    // Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(20)->create();

    get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});
