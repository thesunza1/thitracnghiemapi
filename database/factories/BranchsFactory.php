<?php

namespace Database\Factories;

use App\Models\Branchs;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branchs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'name' => $this->faker->unique()->name(),
           'address' => $this->faker->address(),
        ];
    }
}
