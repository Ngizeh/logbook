<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EntryDateEndingTest extends TestCase
{
	use RefreshDatabase;

	/** @test **/
	public function can_get_entries_for_week_ending_in_a_given_week()
	{
		Carbon::setTestNow('April 18, 2021');
		$thisWeekEntry = Entry::factory()->create();
		$lastWeekEntry = Entry::factory()->create(['created_at' => now()->subWeek()]);

		$user = User::factory()->create();

		$response = $this->actingAs($user)->getJson(route('entries.weekending', 'April 18, 2021'));
		$response->assertJsonFragment(['created_at' => $thisWeekEntry->created_at]);
		$response->assertJsonMissingExact($lastWeekEntry->toArray());
	}

	/** @test **/
	public function can_get_entries_for_a_given_day()
	{
        $this->withoutExceptionHandling();

        Carbon::setTestNow('April 18, 2021');
        $thisWeekEntry = Entry::factory()->create();
        $lastWeekEntry = Entry::factory()->create(['created_at' => now()->subDay()]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('entries.dayEnding', 'April 18, 2021'));
        $response->assertJsonFragment(['created_at' => $thisWeekEntry->created_at]);
        $response->assertJsonMissingExact($lastWeekEntry->toArray());
	}
}
