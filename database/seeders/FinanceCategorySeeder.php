<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\FinanceCategory;
use App\Enums\FinanceCategoryType;

class FinanceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Ingresos
            [
                'name' => 'Ventas de ropa',
                'type' => FinanceCategoryType::Income,
                'description' => 'Ingresos por venta de prendas y accesorios en tienda.',
            ],
            [
                'name' => 'Ventas online',
                'type' => FinanceCategoryType::Income,
                'description' => 'Ingresos por pedidos a través de redes o e-commerce.',
            ],
            [
                'name' => 'Servicios de arreglos',
                'type' => FinanceCategoryType::Income,
                'description' => 'Ingresos por costura, dobladillos y ajustes.',
            ],
            [
                'name' => 'Otros ingresos',
                'type' => FinanceCategoryType::Income,
                'description' => 'Ingresos no operativos o extraordinarios.',
            ],

            // Gastos
            [
                'name' => 'Nómina',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Salarios, prestaciones y pagos al personal.',
            ],
            [
                'name' => 'Arriendo local',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Canon de arriendo del local comercial.',
            ],
            [
                'name' => 'Servicios públicos',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Energía, agua, gas e internet del local.',
            ],
            [
                'name' => 'Marketing y publicidad',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Anuncios en redes, volantes y campañas promocionales.',
            ],
            [
                'name' => 'Transporte y envíos',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Domicilios, mensajería y logística de mercancía.',
            ],
            [
                'name' => 'Compra de mercancía',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Compra de inventario a proveedores (costo de venta).',
            ],
            [
                'name' => 'Mantenimiento',
                'type' => FinanceCategoryType::Expense,
                'description' => 'Reparaciones del local, maniquíes y equipos.',
            ],
            [
                'name' => 'Impuestos y trámites',
                'type' => FinanceCategoryType::Expense,
                'description' => 'ICA, retefuente, renovación de cámara y similares.',
            ],
        ];

        foreach ($categories as $category) {
            FinanceCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'type' => $category['type'],
                'description' => $category['description'],
            ]);
        }
    }
}
