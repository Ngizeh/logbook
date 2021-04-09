<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewIndexEntriesTest extends TestCase
{
	use RefreshDatabase;

	/** @test **/
	public function a_user_can_view_index_entries()
	{
		$this->withoutExceptionHandling();

		$user = factory(User::class)->create();
		$entry = factory(Entry::class)->create();

		$this->actingAs($user)
				->get(route('entries.index'))
				->assertStatus(200)
				->assertViewIs('entries.index')
				->assertSee($entry->title)
				->assertSee($entry->formatted_date)
				->assertSee($entry->description)
				->assertDontSee("No entry found")
				->assertSee(route('entries.show', $entry));
	}

	/** @test **/
	public function user_is_prompted_to_add_an_entry_if_empty()
	{

		$user = factory(User::class)->create();
		$this->assertCount(0, Entry::all());

		$this->actingAs($user)->get(route('entries.index'))
				->assertSee("No entry found")
				->assertSee(route('entries.create'));

	}

	/** @test **/
	public function guest_can_view_index_entries()
	{
		$this->get(route('entries.index'));
		$this->assertGuest();
	}

}
