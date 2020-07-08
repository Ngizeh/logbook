<?php

namespace Tests\Feature;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewEntriesTest extends TestCase
{
    use RefreshDatabase;

    public function validData($parameters = [])
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
       $this->withoutExceptionHandling();

       $user = factory(User::class)->create();

      $this->actingAs($user)
            ->post(route('entries.store'),$this->validData())
            ->assertStatus(201);

       $this->assertDatabaseHas('entries', [
         'type' => 'Test type',
         'description' => 'Test description',
         'title' => 'Test title'
       ]);
   }

    /** @test **/
   public function guests_can_not_create_an_entry()
   {
       $this->post(route('entries.store'), $this->validData())->assertStatus(302);

       $this->assertEmpty(Entry::all());
   }

   /** @test **/
   public function title_is_required_create_an_entry()
   {
       $user = factory(User::class)->create();

       $this->actingAs($user)
            ->post(route('entries.store'),
            $this->validData(['title' => null]))
            ->assertStatus(302)
         ->assertSessionHasErrors('title');

       $this->assertEmpty(Entry::all());
   }

   /** @test **/
   public function description_is_required_create_an_entry()
   {
       $user = factory(User::class)->create();

       $this->actingAs($user)
         ->post(route('entries.store'), $this->validData(['description' => null]))
         ->assertStatus(302)
         ->assertSessionHasErrors('description');

       $this->assertEmpty(Entry::all());
   }

   /** @test **/
   public function type_is_required_create_an_entry()
   {
       $user = factory(User::class)->create();

       $this->actingAs($user)
            ->post(route('entries.store'), $this->validData(['type' => null]))
            ->assertStatus(302)
            ->assertSessionHasErrors('type');

       $this->assertEmpty(Entry::all());
   }


}
