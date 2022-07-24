<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Samsung Galaxy',
                'description' => 'Samsung Brand',
                'image' => 'https://dummyimage.com/200x300/000/fff&text=Samsung',
                'price' => 100
            ],
            [
                'name' => 'Apple iPhone 12',
                'description' => 'Apple Brand',
                'image' => 'https://dummyimage.com/200x300/000/fff&text=Iphone',
                'price' => 500
            ],
            [
                'name' => 'Google Pixel 2 XL',
                'description' => 'Google Pixel Brand',
                'image' => 'https://dummyimage.com/200x300/000/fff&text=Google',
                'price' => 400
            ],
            [
                'name' => 'LG V10 H800',
                'description' => 'LG Brand',
                'image' => 'https://dummyimage.com/200x300/000/fff&text=LG',
                'price' => 200
            ],

            [
                'name' => 'Bag',
                'price' => 350,
                'description' => 'Good Bag',
                'image' => 'https://images.unsplash.com/photo-1491637639811-60e2756cc1c7?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=669&q=80'
        ],
            [
                'name' => 'Watch',
                'price' => 250,
                'description' => 'Good watch',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=989&q=80'
        
            ]
        ];
  
        foreach ($products as $key => $value) {
            Product::create($value);
        }
    }
}
