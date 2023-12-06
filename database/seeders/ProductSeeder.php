<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Assuming you have sections already seeded or available in the sections table
        $sections = DB::table('sections')->pluck('id')->toArray();

        $products = [
            [
                'product_name' => 'Product A',
                'description' => 'Description for Product A',
                'section_id' => $sections[array_rand($sections)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_name' => 'Product B',
                'description' => 'Description for Product B',
                'section_id' => $sections[array_rand($sections)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more products as needed...
        ];

        DB::table('products')->insert($products);
    }

}
