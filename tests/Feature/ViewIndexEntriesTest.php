<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Entry;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewIndexEntriesTest extends TestCase
{
	use RefreshDatabase;

	/** @test **/
	public function a_user_can_view_index_entries()
	{
		$this->withoutExceptionHandling();

		$user = User::factory()->create();
		$entry = Entry::factory()->create();

		$this->actingAs($user)
			->getJson(route('entries.index'))
			->assertStatus(200)
			->assertSee($entry->title)
			->assertSee($entry->formatted_date)
			->assertSee($entry->short_description);
	}

	/** @test **/
	public function user_is_prompted_to_add_an_entry_if_empty()
	{

		$user = User::factory()->create();
		$this->assertCount(0, Entry::all());

		$this->actingAs($user)->get(route('entries.index'));
		//				->assertSee("No entry found")
		//				->assertSee(route('entries.create'));

	}

	/** @test **/
	public function guest_can_view_index_entries()
	{
		$this->get(route('entries.index'));
		$this->assertGuest();
	}

	/** @test **/
	public function only_entries_for_the_current_week_are_shown()
	{
		Carbon::setTestNow('Friday April 9th, 2021');
		$thisWeekEntries = Entry::factory()->create();
		$lastWeekEntries = Entry::factory()->create(['created_at' => now()->subWeek()]);

		$user = User::factory()->create();

		$response = $this->actingAs($user)->get(route('entries.index'));
//		$response->assertSee('April 9, 2021');
        $response->assertDontSee($lastWeekEntries->created_at->format('F j, Y'));
	}

	/** @test **/
	public function list_entries_of_the_week_from_the_first_week_to_the_last_week_entries_and_shows_the_current_week_if_not_listed()
	{
		Carbon::setTestNow('April 18th, 2021');
		Entry::factory()->create(['created_at' => now()->subWeeks(1)]);
		Entry::factory()->create(['created_at' => now()->subWeeks(3)]);

		$user = User::factory()->create();

		$response = $this->actingAs($user)->get(route('entries.index'));
		$response->assertSee('April 11, 2021');
		$response->assertSee('April 4, 2021');
		$response->assertSee('March 28, 2021');
		$response->assertSee('April 18, 2021');
		$entries = Entry::all();
		$response->assertSee('April 18, 2021');
		$this->assertEquals('March 28, 2021', $entries->last()->created_at->format('F j, Y'));
	}

	/** @test **/
	public function current_week_end_is_displayed_if_no_entries_are_found()
	{
		Carbon::setTestNow('April 11th, 2021');

		$this->assertEmpty(Entry::count());

		$user = User::factory()->create();

		$this->actingAs($user)->get(route('entries.index'))->assertSee('April 11, 2021');
	}
}
