<?php

namespace Tests\Unit;

use App\Entry;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function belongs_to_a_category()
    {
      $entry = factory(Entry::class)->create();

      $this->assertInstanceOf(Category::class, $entry->category);
    }

    /** @test **/
    public function has_a_short_description()
    {
        $entry = factory(Entry::class)->create();

        $this->assertEquals(20, strlen($entry->short_description));
    }

    /** @test **/
    public function has_formatted_date_attribute()
    {
        Carbon::setTestNow('April 8th 2021 8:01AM');
        $entry = factory(Entry::class)->create();

        $this->assertEquals('April 8th 2021 8:01AM', $entry->formatted_date);
    }
}
