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

    private mixed $entry;
    private mixed $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();

        $this->entry = Entry::factory()->create($this->validData());
    }

    private function validData($parameters = []): array
    {
        return array_merge([
            'title' => 'New Title',
            'description' => 'New Description',
            'category_id' => $this->category->id
        ], $parameters);
    }

    /** @test **/
    public function authenticated_users_can_edit_an_entry()
    {

        $user = User::factory()->create();

        $this->actingAs($user)->get(route('entries.edit', $this->entry))
            ->assertSee($this->category->name)
            ->assertOk();

        $this->actingAs($user)->patch(route('entries.update', $this->entry), $this->validData())
            ->assertStatus(302);

        $this->assertEquals('New Title', $this->entry->title);
        $this->assertEquals('New Description', $this->entry->description);
        $this->assertEquals(1, $this->entry->category_id);
    }

    /** @test **/
    public function guest_can_not_edit_an_entry()
    {
        $this->get(route('entries.edit', $this->entry))->assertRedirect(route('login'));
        $this->patch(route('entries.update', $this->entry), [])->assertRedirect(route('login'));
    }

    /** @test **/
    public function title_is_required_edit_an_entry()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['title' => null]))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseHas('entries', $this->validData());
    }

    /** @test **/
    public function description_is_required_create_an_entry()
    {

        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['description' => null]))
            ->assertSessionHasErrors('description');

        $this->assertDatabaseHas('entries', $this->validData());
    }

    /** @test **/
    public function category_id_is_required_create_an_entry()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['category_id' => null]))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseHas('entries', $this->validData());
    }
}
