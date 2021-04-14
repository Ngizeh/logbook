<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EntryWeekEndingTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function can_get_entries_for_week_ending_in_a_given_week()
    {
        $this->withoutExceptionHandling();
        Carbon::setTestNow('Friday April 9, 2021');
        $thisWeekEntry = factory(Entry::class)->create();
        $lastWeekEntry = factory(Entry::class)->create(['created_at' => now()->subWeek()]);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('entries.weekending', 'April 9, 2021'));
        $response->assertSee($thisWeekEntry->title);
        $response->assertDontSee($lastWeekEntry->title);
    }
}
