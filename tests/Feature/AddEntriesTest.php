<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Entry;
use App\Models\User;
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
			'category_id' => $this->category->id
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
			->assertStatus(302);

		$this->assertDatabaseHas('entries', [
			'title' => 'Test title',
			'description' => 'Test description',
			'category_id' => $this->category->id
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
	public function required_fields()
	{
		$user = User::factory()->create();
		collect('title', 'description', 'category_id')
		->each(fn($field) => 
			$this->actingAs($user)
			->post(route('entries.store'), $this->validData([$field => null]))
			->assertSessionHasErrors($field)
		);
		$this->assertEmpty(Entry::all());
	}
}
