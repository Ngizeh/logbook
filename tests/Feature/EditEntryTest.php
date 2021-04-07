<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditEntryTest extends TestCase
{
    use RefreshDatabase;

    private $entry;

    public function setUp(): void
    {
        parent::setUp();

        $this->entry = factory(Entry::class)->create([
            'title' => 'New Title',
            'description' => 'New Description',
            'type' => 'New Type'
        ]);
    }


    private function validData($parameters = [])
    {
        return array_merge([
            'title' => 'New Title',
            'description' => 'New Description',
            'type' => 'New Type'
        ], $parameters);
    }


    /** @test **/
    public function authenticated_users_can_edit_an_entry()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $this->actingAs($user)->get(route('entries.edit', $this->entry))
            ->assertViewIs('entries.edit')
            ->assertOk();

        $this->actingAs($user)->patch(route('entries.update', $this->entry), $this->validData())
            ->assertRedirect(route('entries.show', $this->entry));

        $this->assertEquals('New Title', $this->entry->fresh()->title);
        $this->assertEquals('New Description', $this->entry->fresh()->description);
        $this->assertEquals('New Type', $this->entry->fresh()->type);
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

        tap($this->entry->fresh(), function ($entry) {
            $this->assertEquals('New Title', $entry->title);
            $this->assertEquals('New Description', $entry->description);
            $this->assertEquals('New Type', $entry->type);
        });
    }

    /** @test **/
    public function description_is_required_create_an_entry()
    {

        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['description' => null]))
            ->assertSessionHasErrors('description');

        tap($this->entry->fresh(), function ($entry) {
            $this->assertEquals('New Title', $entry->title);
            $this->assertEquals('New Description', $entry->description);
            $this->assertEquals('New Type', $entry->type);
        });
    }

    /** @test **/
    public function type_is_required_create_an_entry()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->patch(route('entries.update', $this->entry), $this->validData(['type' => null]))
            ->assertSessionHasErrors('type');

        tap($this->entry->fresh(), function ($entry) {
            $this->assertEquals('New Title', $entry->title);
            $this->assertEquals('New Description', $entry->description);
            $this->assertEquals('New Type', $entry->type);
        });
    }
}
