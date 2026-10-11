<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('authenticated users can view category pages', function () {
    $user = User::factory()->create();
    $category = Category::create([
        'name' => 'Books',
        'description' => 'Printed books',
        'image' => 'images/books.jpg',
        'status' => true,
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertSuccessful()
        ->assertSee('Books');

    $this->get(route('categories.create'))->assertSuccessful();
    $this->get(route('categories.show', $category))->assertSuccessful()->assertSee('Printed books');
    $this->get(route('categories.edit', $category))->assertSuccessful();
});

test('authenticated users can create update and delete categories', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->post(route('categories.store'), [
        'name' => 'Books',
        'description' => 'Printed books',
        'image' => UploadedFile::fake()->createWithContent('books.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p8sAAAAASUVORK5CYII=')),
        'status' => '1',
    ])
        ->assertRedirect(route('categories.index'));

    $category = Category::query()->firstOrFail();
    $originalImage = $category->image;

    expect($originalImage)->toStartWith('categories/');
    Storage::disk('public')->assertExists($originalImage);

    $this->put(route('categories.update', $category), [
        'name' => 'Books',
        'description' => 'Printed books',
        'status' => '1',
    ])->assertRedirect(route('categories.index'));

    expect($category->fresh()->image)->toBe($originalImage);
    Storage::disk('public')->assertExists($originalImage);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Books',
        'created_by' => $user->id,
        'updated_by' => $user->id,
    ]);

    $this->put(route('categories.update', $category), [
        'name' => 'Updated books',
        'description' => 'Updated description',
        'image' => UploadedFile::fake()->createWithContent('updated-books.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p8sAAAAASUVORK5CYII=')),
        'status' => '0',
    ])
        ->assertRedirect(route('categories.index'));

    $category->refresh();
    $updatedImage = $category->image;

    expect($updatedImage)->not->toBe($originalImage);
    Storage::disk('public')->assertMissing($originalImage);
    Storage::disk('public')->assertExists($updatedImage);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Updated books',
        'status' => false,
        'updated_by' => $user->id,
    ]);

    $this->delete(route('categories.destroy', $category))
        ->assertRedirect(route('categories.index'));

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    Storage::disk('public')->assertMissing($updatedImage);
});

test('category inputs are validated', function () {
    Storage::fake('public');

    $this->actingAs(User::factory()->create())
        ->from(route('categories.create'))
        ->post(route('categories.store'), [
            'name' => '',
            'description' => str_repeat('a', 256),
            'image' => UploadedFile::fake()->create('invalid.txt', 10, 'text/plain'),
            'status' => 'invalid',
        ])
        ->assertRedirect(route('categories.create'))
        ->assertSessionHasErrors(['name', 'description', 'image', 'status']);
});

test('guests are redirected away from category management', function () {
    $this->get(route('categories.index'))
        ->assertRedirect(route('login'));
});
