<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditEntryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->entry = Entry::factory()->create($this->validData());
    }

    /** @test **/
    public function authenticated_users_can_edit_an_entry()
    {
        $this->actingAs($this->user)->get(route('entries.edit', $this->entry))
            ->assertSee($this->category->name)
            ->assertOk();

        $this->actingAs($this->user)->patch(route('entries.update', $this->entry), $this->validData([
            'title' => 'New Title',
            'description' => 'New Description',
            'category_id' => $this->category->id
        ]))
            ->assertStatus(302);

        tap($this->entry->fresh(), function ($entry) {
            $this->assertEquals('New Title', $entry->title);
            $this->assertEquals('New Description', $entry->description);
            $this->assertEquals(1, $this->entry->category_id);
        });
    }

    /** @test **/
    public function guest_can_not_edit_an_entry()
    {
        $this->get(route('entries.edit', $this->entry))->assertRedirect(route('login'));
        $this->patch(route('entries.update', $this->entry), [])->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /** @test **/
    public function required_field_for_an_update()
    {
        collect('title', 'description', 'category_id')
            ->each(
                fn ($field) =>
                $this->actingAs($this->user)->patch(route('entries.update', $this->entry), $this->validData([$field => null]))
                    ->assertSessionHasErrors($field)
            );
        $this->assertDatabaseHas('entries', $this->validData());
    }
}
