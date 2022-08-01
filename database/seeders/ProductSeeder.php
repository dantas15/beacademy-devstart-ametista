<?php

namespace Database\Seeders;

use App\Models\{
    Category,
    Product,
};
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create([
            'category_id' => Category::factory()->create()->id
        ]);
        Product::factory(10)->create([
            'category_id' => Category::factory()->create()->id
        ]);
    }
}
