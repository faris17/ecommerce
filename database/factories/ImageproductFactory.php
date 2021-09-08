<?php

namespace Database\Factories;

use App\Models\Imageproduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageproductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Imageproduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'imageproducturl' =>
            $this->faker->image('public/upload/products', 640, 480, null, false),
            'keteranganproduct' => $this->faker->words('5', true),
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
