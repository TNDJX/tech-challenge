<?php

namespace Tests\Feature;

use App\Journal;
use App\User;
use Tests\TestCase;

class JournalTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $user = factory(User::class)->create();

        $this->actingAs($user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanGetJournals()
    {
        $journal = factory(Journal::class)->create();

        $response = $this->get('/clients/'.$journal->client->id.'/journals');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $journal->id,
            'date' => $journal->date,
            'content' => $journal->content,
        ]);
    }

    public function testCanCreateJournal()
    {
        $journal = factory(Journal::class)->make();

        $response = $this->post('/clients/'.$journal->client->id.'/journals', [
            'date' => $journal->date,
            'content' => $journal->content
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'date' => $journal->date,
            'content' => $journal->content,
        ]);
    }

    public function testCanDeleteJournal()
    {
        $journal = factory(Journal::class)->create();

        $response = $this->delete('/clients/'.$journal->client->id.'/journals/'.$journal->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('journals', [
            'id' => $journal->id
        ]);
    }
}
