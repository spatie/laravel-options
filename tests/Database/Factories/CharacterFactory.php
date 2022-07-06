<?php

namespace Spatie\LaravelOptions\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\LaravelOptions\Tests\Fakes\Model\Character;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'kind' => 'hobbit',
        ];
    }
}
