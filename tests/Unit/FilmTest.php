<?php

namespace Tests\Unit;

use App\Models\Film;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class FilmTest extends TestCase
{
    use RefreshDatabase;

    /**
     * get all films.
     *
     * @return void
     */
    public function test_get_all_films()
    {
        $genre = Genre::factory()->create();
        Film::factory()->count(5)->create(['genre_id' => $genre->first()->id]);
        $response = $this->getJson(route('films.index'));
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => [
                'id',
                'title',
                'year',
                'country',
                'genre',
            ]]);
    }

    /**
     * get film by id
     */
    public function test_get_film_by_id()
    {
        $genre = Genre::factory()->create();
        $films = Film::factory()->count(5)->create(['genre_id' => $genre->id]);
        $response = $this->getJson(route('films.show', ['film' => $films->random()]));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'year',
                'country',
                'genre',
            ]);
    }

    /**
     * get  film whose id does not exist
     */
    public function test_get_film_by_non_existent_id()
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create(['genre_id' => $genre->first()->id]);
        $response = $this->getJson(route('films.show', ['film' => 999]));
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * create new film
     */
    public function test_store_film()
    {
        $genre = Genre::factory()->create();

        $payload = [
            'title' => 'название фильма',
            'year' => 2020,
            'country' => 'РФ',
            'genre_id' => $genre->first()->id,
        ];
        $response = $this->postJson(route('films.store'), $payload);
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'year',
                'country',
                'genre',
            ]);
    }

    /**
     * create new film without title
     */
    public function test_store_film_with_missing_title()
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create(['genre_id' => $genre->first()->id]);

        $payload = [
            'title' => '',
            'year' => $film->year,
            'country' => $film->country,
            'genre_id' => $film->genre->id,
        ];
        $response = $this->postJson(route('films.store'), $payload);
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
     * update film
     */
    public function test_update_film()
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create(['genre_id' => $genre->first()->id]);

        $payload = [
            'title' => 'Обновленное название',
            'year' => 2003,
            'country' => 'USA',
            'genre_id' => $film->genre->id,
        ];
        $response = $this->putJson(route('films.update', ['film' => $film]), $payload);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'year',
                'country',
                'genre',
            ]);
    }

    /**
     * test film without title
     */
    public function test_update_film_with_missing_title()
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create(['genre_id' => $genre->first()->id]);

        $payload = [
            'title' => '',
            'year' => 2003,
            'country' => 'USA',
            'genre_id' => $film->genre->id,
        ];
        $response = $this->putJson(route('films.update', ['film' => $film]), $payload);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'title'
                ]
            ]);
    }

    /**
     * delete film
     */
    public function test_delete_film()
    {
        $genre = Genre::factory()->create();
        $film = Film::factory()->create(['genre_id' => $genre->first()->id]);
        $response = $this->deleteJson(route('films.destroy', ['film' => $film]));
        $response->assertStatus(204);
    }

    /**
     * delete film whose id does not exist
     */
    public function test_delete_film_id_does_not_exist()
    {
        $genre = Genre::factory()->create();
        Film::factory()->create(['genre_id' => $genre->first()->id]);
        $response = $this->deleteJson(route('films.destroy', ['film' => 999]));
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
