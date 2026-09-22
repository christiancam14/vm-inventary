<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $cats = Category::pluck('id', 'slug')->toArray();
        $units = Unit::pluck('id', 'symbol')->toArray();

        $getCat = fn ($name) => $cats[Str::slug($name)] ?? array_first($cats);
        $getUnit = fn ($sym) => $units[$sym] ?? array_first($units);

        // Precios de venta en pesos colombianos (COP)
        $products = [
            // Camisetas y Polos
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta básica algodón blanca - S', 'p' => 39900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta básica algodón blanca - M', 'p' => 39900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta básica algodón blanca - L', 'p' => 39900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta básica algodón negra - M', 'p' => 39900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta oversize gris - M', 'p' => 54900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Camiseta oversize gris - L', 'p' => 54900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Polo piqué azul navy - M', 'p' => 69900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Polo piqué azul navy - L', 'p' => 69900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Crop top rib negro - S', 'p' => 44900],
            ['cat' => 'Camisetas y Polos', 'u' => 'und', 'n' => 'Crop top rib negro - M', 'p' => 44900],

            // Camisas
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Camisa formal blanca slim - M', 'p' => 89900],
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Camisa formal blanca slim - L', 'p' => 89900],
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Camisa linen beige - M', 'p' => 119900],
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Camisa cuadros flannel - L', 'p' => 99900],
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Blusa satín champagne - S', 'p' => 79900],
            ['cat' => 'Camisas', 'u' => 'und', 'n' => 'Blusa satín champagne - M', 'p' => 79900],

            // Pantalones y Jeans
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jean skinny azul oscuro - 28', 'p' => 129900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jean skinny azul oscuro - 30', 'p' => 129900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jean skinny azul oscuro - 32', 'p' => 129900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jean wide leg claro - 28', 'p' => 149900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jean wide leg claro - 30', 'p' => 149900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jogger cargo khaki - M', 'p' => 109900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Jogger cargo khaki - L', 'p' => 109900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Pantalón de vestir negro - 32', 'p' => 139900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Short denim azul - 28', 'p' => 79900],
            ['cat' => 'Pantalones y Jeans', 'u' => 'und', 'n' => 'Short denim azul - 30', 'p' => 79900],

            // Vestidos y Faldas
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Vestido midi floral - S', 'p' => 119900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Vestido midi floral - M', 'p' => 119900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Vestido negro cóctel - S', 'p' => 159900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Vestido negro cóctel - M', 'p' => 159900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Falda plisada beige - S', 'p' => 69900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Falda plisada beige - M', 'p' => 69900],
            ['cat' => 'Vestidos y Faldas', 'u' => 'und', 'n' => 'Enterizo linen verde - M', 'p' => 134900],

            // Chaquetas y Buzos
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Buzo hoodie negro - M', 'p' => 119900],
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Buzo hoodie negro - L', 'p' => 119900],
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Chaqueta denim clásica - M', 'p' => 179900],
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Chaqueta denim clásica - L', 'p' => 179900],
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Blazer estructurado negro - M', 'p' => 199900],
            ['cat' => 'Chaquetas y Buzos', 'u' => 'und', 'n' => 'Chaqueta bomber olive - L', 'p' => 169900],

            // Ropa Deportiva
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Leggins high waist negros - S', 'p' => 79900],
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Leggins high waist negros - M', 'p' => 79900],
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Top deportivo rosa - S', 'p' => 49900],
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Top deportivo rosa - M', 'p' => 49900],
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Short running negro - M', 'p' => 59900],
            ['cat' => 'Ropa Deportiva', 'u' => 'und', 'n' => 'Conjunto fitness gris - M', 'p' => 129900],

            // Accesorios
            ['cat' => 'Accesorios', 'u' => 'und', 'n' => 'Cinturón cuero café', 'p' => 49900],
            ['cat' => 'Accesorios', 'u' => 'und', 'n' => 'Gorra trucker negra', 'p' => 39900],
            ['cat' => 'Accesorios', 'u' => 'und', 'n' => 'Bolso tote canvas', 'p' => 89900],
            ['cat' => 'Accesorios', 'u' => 'und', 'n' => 'Riñonera urbana negra', 'p' => 59900],
            ['cat' => 'Accesorios', 'u' => 'und', 'n' => 'Pañuelo satín estampado', 'p' => 34900],

            // Calzado
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Tenis urbanos blancos - 37', 'p' => 159900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Tenis urbanos blancos - 39', 'p' => 159900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Tenis urbanos blancos - 41', 'p' => 159900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Zapato formal negro - 40', 'p' => 189900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Zapato formal negro - 42', 'p' => 189900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Sandalia plataforma nude - 37', 'p' => 119900],
            ['cat' => 'Calzado', 'u' => 'par', 'n' => 'Botín chelsea café - 38', 'p' => 209900],
        ];

        foreach ($products as $index => $item) {
            // ~70% of products get an optional barcode (Colombia-style 770 prefix)
            $hasBarcode = ($index % 10) < 7;

            Product::create([
                'category_id' => $getCat($item['cat']),
                'unit_id' => $getUnit($item['u']),
                'sku' => 'MU-' . strtoupper(Str::random(6)),
                'barcode' => $hasBarcode ? $this->makeBarcode($index) : null,
                'name' => $item['n'],
                'description' => 'Prenda disponible: ' . $item['n'],
                'purchase_price' => (int) round($item['p'] * 0.55),
                'selling_price' => $item['p'],
                'quantity' => rand(5, 40),
                'min_stock' => 3,
                'is_active' => true,
            ]);
        }
    }

    private function makeBarcode(int $index): string
    {
        return '770' . str_pad((string) (1000000000 + $index), 10, '0', STR_PAD_LEFT);
    }
}
