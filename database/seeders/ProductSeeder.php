<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            // Processors
            [
                'name' => 'Intel Core i9-14900K',
                'category' => 'Processor',
                'price' => 8500000,
                'image' => 'https://images.unsplash.com/photo-1555617981-dac3880eac6e?w=400',
                'stock' => 15,
            ],
            [
                'name' => 'AMD Ryzen 9 7950X',
                'category' => 'Processor',
                'price' => 9200000,
                'image' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?w=400',
                'stock' => 12,
            ],
            [
                'name' => 'Intel Core i7-14700K',
                'category' => 'Processor',
                'price' => 6500000,
                'image' => 'https://images.unsplash.com/photo-1555617981-dac3880eac6e?w=400',
                'stock' => 20,
            ],

            // Graphics Cards
            [
                'name' => 'NVIDIA RTX 4090',
                'category' => 'Graphics Card',
                'price' => 28500000,
                'image' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=400',
                'stock' => 8,
            ],
            [
                'name' => 'AMD RX 7900 XTX',
                'category' => 'Graphics Card',
                'price' => 18500000,
                'image' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?w=400',
                'stock' => 10,
            ],
            [
                'name' => 'NVIDIA RTX 4070 Ti',
                'category' => 'Graphics Card',
                'price' => 15500000,
                'image' => 'https://images.unsplash.com/photo-1591488320449-011701bb6704?w=400',
                'stock' => 15,
            ],

            // Motherboards
            [
                'name' => 'ASUS ROG Maximus Z790',
                'category' => 'Motherboard',
                'price' => 8500000,
                'image' => 'https://images.unsplash.com/photo-1600861194942-f883e97edc41?w=400',
                'stock' => 10,
            ],
            [
                'name' => 'MSI MPG B650 Carbon',
                'category' => 'Motherboard',
                'price' => 5500000,
                'image' => 'https://images.unsplash.com/photo-1600861194775-eb97b1c87d21?w=400',
                'stock' => 12,
            ],

            // Memory
            [
                'name' => 'Corsair Dominator 32GB DDR5',
                'category' => 'Memory',
                'price' => 4500000,
                'image' => 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?w=400',
                'stock' => 25,
            ],
            [
                'name' => 'G.Skill Trident Z5 64GB DDR5',
                'category' => 'Memory',
                'price' => 8500000,
                'image' => 'https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?w=400',
                'stock' => 15,
            ],

            // Cases
            [
                'name' => 'Lian Li O11 Dynamic EVO',
                'category' => 'Case',
                'price' => 3500000,
                'image' => 'https://images.unsplash.com/photo-1587202372634-32705e3bf49c?w=400',
                'stock' => 20,
            ],
            [
                'name' => 'NZXT H9 Elite',
                'category' => 'Case',
                'price' => 4200000,
                'image' => 'https://images.unsplash.com/photo-1587202372583-49330a15584d?w=400',
                'stock' => 18,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
