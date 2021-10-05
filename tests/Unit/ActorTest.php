<?php

namespace Tests\Feature;

use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * get all actors.
     *
     * @return void
     */
    public function test_get_all_actors()
    {
        Actor::factory()->count(1)->create();
        $response = $this->getJson('/api/actors/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['*' => [
                'id',
                'name',
                'gender',
                'born',
            ]]);
    }

    /**
     * get actor by id
     */
    public function test_get_actor_by_id()
    {
        $actor = Actor::factory()->create();
        $response = $this->getJson('/api/actors/' . $actor->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'gender',
                'born',
            ]);
    }

    /**
     * get  actor whose id does not exist
     */
    public function test_get_actor_by_non_existent_id()
    {
        Actor::factory()->count(1)->create();
        $response = $this->getJson('/api/actors/' . 999);
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }

    /**
     * create new actor
     */
    public function test_store_actor()
    {
        $payload = [
            'name' => 'Иванов Иван',
            'gender' => 'male',
            'born' => '1981-02-23',
        ];
        $response = $this->postJson('/api/actors', $payload);
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'gender',
                'born',
            ]);
    }

    /**
     * create new actor without name
     */
    public function test_store_actor_with_missing_name()
    {
        $payload = [
            'name' => '',
            'gender' => 'male',
            'born' => '1981-02-23',
        ];
        $response = $this->postJson('/api/actors', $payload);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name'
                ]
            ]);
    }

    /**
     * update actor
     */
    public function test_update_actor()
    {
        $actor = Actor::factory()->create();
        $payload = [
            'name' => 'Новое имя',
            'gender' => 'male',
            'born' => '1981-02-23',
        ];
        $response = $this->putJson("/api/actors/" . $actor->id, $payload);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'gender',
                'born',
            ]);
    }

    /**
     * test actor without name
     */
    public function test_update_actor_with_missing_name()
    {
        $actor = Actor::factory()->create();
        $payload = [
            'name' => '',
            'gender' => 'male',
            'born' => '1981-02-23',
        ];
        $response = $this->putJson("/api/actors/" . $actor->id, $payload);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'name'
                ]
            ]);
    }

    /**
     * delete actor
     */
    public function test_delete_actor()
    {
        $actor = Actor::factory()->create();
        $response = $this->deleteJson('/api/actors/' . $actor->id);
        $response->assertStatus(204);
    }

    /**
     * delete actor whose id does not exist
     */
    public function test_delete_actor_id_does_not_exist()
    {
        Actor::factory()->create();
        $response = $this->deleteJson('/api/actors/' . 999);
        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
