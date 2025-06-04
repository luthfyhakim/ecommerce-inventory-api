<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category1 = Category::find(1);
        $category2 = Category::find(2);
        $category3 = Category::find(3);

        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'price' => 100.00,
                'stock_quantity' => 50,
                'category_id' => $category1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 2',
                'price' => 200.00,
                'stock_quantity' => 30,
                'category_id' => $category2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Product 3',
                'price' => 150.00,
                'stock_quantity' => 20,
                'category_id' => $category3->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
