<?php

namespace Database\Factories;

use App\Models\Owner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Owner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'namausaha' => $this->faker->words(3, true),
            'deskripsiowner' => $this->faker->paragraphs(3, true),
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
