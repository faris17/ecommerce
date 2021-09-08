<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Product::factory(30)->create();
        \App\Models\CategoryHasProduct::factory(10)->create();
        \App\Models\Imageproduct::factory(10)->create();
    }
}
