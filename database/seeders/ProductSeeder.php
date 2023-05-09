<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= 10000; $i++){

            $product_guid = $faker->uuid();

            Product::create([
                'guid' => $product_guid,
                'name' => $faker->sentence
            ]);

            for ($j = 1; $j <= 100; $j++){
                Price::create([
                    'product_guid' => $product_guid,
                    'price' => $faker->randomFloat(2, 1, 500000)
                ]);
            }
        }
    }


}
