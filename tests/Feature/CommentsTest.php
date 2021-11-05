<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;

class CommentsTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /**
     * Test fetching comments list
     * It should be empty at starting point
     * 
     *
     * @return void
     */
    public function test_empty_list()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/comments');

        $response->assertOk();
        $response->assertJsonCount(0);
    }

    /**
     * Test successfully storing a comment into the DB
     * 
     *
     * @return void
     */
    public function test_successful_store()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/comments', [
            'name' => $this->faker->name(),
            'body' => $this->faker->text(),
        ]);

        $response->assertCreated();
    }

    /**
     * Test validation failure of storing comment
     * 
     *
     * @return void
     */
    public function test_validation_failure()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/comments');

        $response->assertUnprocessable();
    }
}
