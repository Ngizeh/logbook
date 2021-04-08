<?php

namespace Tests\Feature;

use App\Category;
use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditEntryTest extends TestCase
{
    use RefreshDatabase;

    private $entry;
    private $category;

    public function setUp(): void
    {
        parent::setUp();

        $this->category = factory(Category::class)->create();

        $this->entry = factory(Entry::class)->create($this->validData());
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

        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('entries.edit', $this->entry))
            ->assertSee($this->category->name)
            ->assertViewIs('entries.edit')
            ->assertOk();

        $this->actingAs($user)->patch(route('entries.update', $this->entry), $this->validData())
            ->assertRedirect(route('entries.show', $this->entry));

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
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['title' => null]))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseHas('entries', $this->validData());
    }

    /** @test **/
    public function description_is_required_create_an_entry()
    {

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['description' => null]))
            ->assertSessionHasErrors('description');

        $this->assertDatabaseHas('entries', $this->validData());
    }

    /** @test **/
    public function category_id_is_required_create_an_entry()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['category_id' => null]))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseHas('entries', $this->validData());
    }
}
