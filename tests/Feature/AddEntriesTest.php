<?php

namespace Tests\Feature;

use App\Category;
use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddEntriesTest extends TestCase
{
    use RefreshDatabase;

    private $category;

    public function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    public function validData($parameters = []): array
    {
        return array_merge([
            'title' => 'Test title',
            'description' => 'Test description',
            'category_id' => $this->category->id,
        ], $parameters);
    }

    /** @test **/
    public function can_create_post_an_entry()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user)->get(route('entries.create'))
            ->assertSee($this->category->name)
            ->assertStatus(200);

        $this->actingAs($user)
            ->postJson(route('entries.store'), $this->validData())
            ->assertStatus(201);

        $this->assertDatabaseHas('entries', [
            'title' => 'Test title',
            'description' => 'Test description',
            'category_id' => $this->category->id,
        ]);
    }

    /** @test **/
    public function guests_can_not_create_an_entry()
    {
        $this->get(route('entries.create'));
        $this->assertGuest();

        $this->post(route('entries.store'), $this->validData());
        $this->assertGuest();

        $this->assertEmpty(Entry::all());
    }

    /** @test **/
    public function title_is_required_create_an_entry()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('entries.store'), $this->validData(['title' => null]))
            ->assertSessionHasErrors('title');

        $this->assertEmpty(Entry::all());
    }

    /** @test **/
    public function description_is_required_create_an_entry()
    {

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('entries.store'), $this->validData(['description' => null]))
            ->assertSessionHasErrors('description');

        $this->assertEmpty(Entry::all());
    }

    /** @test **/
    public function category_Id_is_required_create_an_entry()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('entries.store'), $this->validData(['category_id' => null]))
            ->assertSessionHasErrors('category_id');

        $this->assertEmpty(Entry::all());
    }
}
