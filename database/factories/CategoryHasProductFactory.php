<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryHasProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryHasProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryHasProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id
        ];
    }
}
