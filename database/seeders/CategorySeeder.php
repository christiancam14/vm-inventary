<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Camisetas y Polos',
                'description' => 'Camisetas básicas, oversize, polos y tops casuales.',
            ],
            [
                'name' => 'Camisas',
                'description' => 'Camisas formales, casuales y de vestir para hombre y mujer.',
            ],
            [
                'name' => 'Pantalones y Jeans',
                'description' => 'Jeans, joggers, pantalones de vestir y cargo.',
            ],
            [
                'name' => 'Vestidos y Faldas',
                'description' => 'Vestidos casuales, de fiesta, faldas y enterizos.',
            ],
            [
                'name' => 'Chaquetas y Buzos',
                'description' => 'Chaquetas, buzos, hoodies, blazers y abrigos ligeros.',
            ],
            [
                'name' => 'Ropa Deportiva',
                'description' => 'Leggins, shorts deportivos, tops y conjuntos fitness.',
            ],
            [
                'name' => 'Accesorios',
                'description' => 'Cinturones, gorras, bufandas, bolsos y complementos.',
            ],
            [
                'name' => 'Calzado',
                'description' => 'Tenis, zapatos formales, sandalias y botines.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
