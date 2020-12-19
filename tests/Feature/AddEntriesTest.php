<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddEntriesTest extends TestCase
{
	use RefreshDatabase;

	public function validData($parameters = []): array
	{
		return array_merge([
			'type' => 'Test type',
			'description' => 'Test description',
			'title' => 'Test title'
		], $parameters);
	}

	/** @test **/
	public function can_create_post_an_entry()
	{

		$user = factory(User::class)->create();

		$this->actingAs($user)->get(route('entries.create'))->assertStatus(200);

		$this->actingAs($user)
		->postJson(route('entries.store'),$this->validData())
		->assertStatus(302);

		$this->assertDatabaseHas('entries', [
			'type' => 'Test type',
			'description' => 'Test description',
			'title' => 'Test title'
		]);
	}

	/** @test **/
	public function guests_can_not_create_an_entry()
	{
	    $this->get(route('entries.create'))->assertRedirect(route('login'));
		$this->post(route('entries.store'), $this->validData())->assertRedirect(route('login'));

		$this->assertEmpty(Entry::all());
	}

	/** @test **/
	public function title_is_required_create_an_entry()
	{
		$user = factory(User::class)->create();

		$this->actingAs($user)
				->post(route('entries.store'),$this->validData(['title' => null]))
				->assertSessionHasErrors('title');

		$this->assertEmpty(Entry::all());
	}

	/** @test **/
	public function description_is_required_create_an_entry()
	{

		$user = factory(User::class)->create();

		$this->actingAs($user)
				->post(route('entries.store'), $this->validData(['description' => null]))
				->assertSessionHasErrors('description');

		$this->assertEmpty(Entry::all());
	}

	/** @test **/
	public function type_is_required_create_an_entry()
	{
		$user = factory(User::class)->create();

		$this->actingAs($user)
				->post(route('entries.store'), $this->validData(['type' => null]))
				->assertSessionHasErrors('type');

		$this->assertEmpty(Entry::all());
	}


}
