<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewEntriesTest extends TestCase
{
	use RefreshDatabase;

	/** @test **/
	public function a_user_can_view_an_entry()
	{
		$this->withoutExceptionHandling();

		$user = factory(User::class)->create();
		$entry = factory(Entry::class)->create();

		$this->actingAs($user)
				->get(route('entries.show', $entry))
				->assertStatus(200)
				->assertViewHas('entry', $entry)
				->assertSee($entry->title)
				->assertSee($entry->type)
				->assertSee($entry->description);


	}
	/** @test **/
	public function guest_can_not_view_an_entry()
	{
		$entry = factory(Entry::class)->create();
		$this->get(route('entries.show', $entry))->assertRedirect(route('login'));
	}


}
