<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewEntryTest extends TestCase
{
	use RefreshDatabase;

	/** @test **/
	public function a_user_can_view_an_entry()
	{
		$this->withoutExceptionHandling();

		$user = User::factory()->create();
		$entry = Entry::factory()->create();

		$this->actingAs($user)
				->get(route('entries.show', $entry))
				->assertStatus(200)
				->assertViewHas('entry', $entry)
				->assertSee($entry->title)
				->assertSee($entry->type)
				->assertSee($entry->short_description)
				->assertSee($entry->formatted_date);
	}

	/** @test **/
	public function guest_can_not_view_an_entry()
	{
		$entry = Entry::factory()->create();
		$this->get(route('entries.show', $entry));
        $this->assertGuest();
	}


}
