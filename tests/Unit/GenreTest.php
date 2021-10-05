<?php

namespace Tests\Unit;

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * get all genres.
     *
     * @return void
     */
    public function test_get_all_genres()
    {
        Genre::factory()->count(1)->create();
        $response = $this->getJson('/api/genres/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => [
                'id',
                'title',
            ]]);
    }

    /**
     * get genre by id
     */
    public function test_get_genre_by_id()
    {
        $actor = Genre::factory()->create();
        $response = $this->getJson('/api/genres/' . $actor->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
            ]);
    }

    /**
     * get  genre whose id does not exist
     */
    public function test_get_genre_by_non_existent_id()
    {
        Genre::factory()->count(1)->create();
        $response = $this->getJson('/api/genres/' . 999);
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * create new genre
     */
    public function test_store_genre()
    {
        $payload = [
            'title' => 'Новый Жанр',
        ];
        $response = $this->postJson('/api/genres', $payload);
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
            ]);
    }

    /**
     * create new genre without title
     */
    public function test_store_genre_with_missing_title()
    {
        $payload = [
            'title' => '',
        ];
        $response = $this->postJson('/api/genres', $payload);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'title'
                ]
            ]);
    }

    /**
     * update genre
     */
    public function test_update_genre()
    {
        $genre = Genre::factory()->create();
        $payload = [
            'title' => 'Обновленный жанр',
        ];
        $response = $this->putJson("/api/genres/" . $genre->id, $payload);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
            ]);
    }

    /**
     * test genre without title
     */
    public function test_update_genre_with_missing_title()
    {
        $genre = Genre::factory()->create();
        $payload = [
            'title' => '',
        ];
        $response = $this->putJson("/api/genres/" . $genre->id, $payload);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'title'
                ]
            ]);
    }

    /**
     * delete genre
     */
    public function test_delete_genre()
    {
        $genre = Genre::factory()->create();
        $response = $this->deleteJson('/api/genres/' . $genre->id);
        $response->assertStatus(204);
    }

    /**
     * delete genre whose id does not exist
     */
    public function test_delete_genre_id_does_not_exist()
    {
        Genre::factory()->create();
        $response = $this->deleteJson('/api/genres/' . 999);
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
