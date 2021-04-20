<?php

namespace Tests;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	public function setUp(): void
	{
		parent::setUp();
		$this->category = Category::factory()->create();
		$this->user = User::factory()->create();
	}

    public function validData($parameters = []): array
	{
		return array_merge([
			'title' => 'Test title',
			'description' => 'Test description',
			'category_id' => $this->category->id
		], $parameters);
	}
}
