<?php

namespace Tests\Unit;

use App\Entry;
use App\Category;
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
}
