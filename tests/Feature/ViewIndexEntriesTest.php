<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Carbon\Carbon;
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
				->assertSee($entry->short_description)
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

	/** @test **/
	public function only_entries_for_the_current_week_are_shown()
	{
	    Carbon::setTestNow('Friday April 9th, 2021');
	    $thisWeekEntry = factory(Entry::class)->create();
	    $lastWeekEntry = factory(Entry::class)->create(['created_at' => now()->subWeek()]);

	    $user = factory(User::class)->create();

	    $this->actingAs($user)->get(route('entries.index'))
            ->assertViewHas('entries', function($entries) use ($thisWeekEntry, $lastWeekEntry){
                if(!$entries->contains($thisWeekEntry)){
                    $this->fail('This week entries are not shown');
                }
                if($entries->contains($lastWeekEntry)){
                    $this->fail('Found last week entries');
                }
                return true;
            });
	}

}
