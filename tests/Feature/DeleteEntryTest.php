<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function can_delete_an_entry()
    {
        $user = factory(User::class)->create();
        $entry = factory(Entry::class)->create();

        $this->actingAs($user)->delete(route('entries.destroy', $entry))->assertRedirect(route('entries.index'));

        $this->assertDatabaseMissing('entries', [$entry]);
    }

    /** @test **/
    public function guests_can_not_delete_an_entry()
    {
        $entry = factory(Entry::class)->create();

        $this->delete(route('entries.destroy', $entry))->assertRedirect(route('login'));

        $this->assertNotNull($entry);
    }
}
