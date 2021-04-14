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
				->assertSee($entry->short_description);
//				->assertDontSee("No entry found")
//				->assertSee(route('entries.show', $entry));
	}

	/** @test **/
	public function user_is_prompted_to_add_an_entry_if_empty()
	{

		$user = factory(User::class)->create();
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

	/** @test **/
	public function list_entries_of_the_week_from_the_first_week_to_the_last_week_entries()
	{
        Carbon::setTestNow('April 11th, 2021');
        factory(Entry::class)->create();
        factory(Entry::class)->create(['created_at' => now()->subWeeks(3)]);

        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('entries.index'))
            ->assertViewHas('entriesDate', function($dates){
                $this->assertContains('April 11, 2021', $dates);
                $this->assertContains('April 4, 2021', $dates);
                $this->assertContains('March 28, 2021', $dates);
                $this->assertContains('March 21, 2021', $dates);

                $this->assertEquals('April 11, 2021', $dates[0]);
                $this->assertEquals('March 21, 2021', $dates[3]);

                return true;
            });
    }

    /** @test **/
	public function current_week_end_is_displayed_if_no_entries_are_found()
	{
        Carbon::setTestNow('April 11th, 2021');

        $this->assertEmpty(Entry::count());

        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('entries.index'))
            ->assertViewHas('entriesDate', function($dates){
                $this->assertContains('April 11, 2021', $dates);
                return true;
            });
    }

}
