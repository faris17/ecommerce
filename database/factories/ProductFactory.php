<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'namaproduk' => $this->faker->words(3, true),
            'hargasatuan' => $this->faker->numberBetween(5000, 200000),
            'hargacoret' => $this->faker->numberBetween(60000, 300000),
            'diskon' => $this->faker->numberBetween(5, 20),
            'satuan' => $this->faker->randomElement(['kilo', 'liter', 'pieces', 'buah', 'meter', 'ikat', 'lusin', 'butir', 'ons', 'gram', 'sak', 'botol', 'sachet']),
            'stock' => $this->faker->numberBetween(5, 100),
            'ukuran' => $this->faker->randomElement(['s', 'l', 'm', 'xl', 'x']),
            'deskripsi' => $this->faker->paragraphs(2, true),
            'ongkir' => $this->faker->numberBetween(0, 100000),
            'jenispembayaran' => $this->faker->randomElement(['cod', 'transfer']),
            'owner_id' => Owner::inRandomOrder()->first()->id,
        ];
    }
}
