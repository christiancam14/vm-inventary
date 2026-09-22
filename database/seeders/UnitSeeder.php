<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Unidad', 'symbol' => 'und'],
            ['name' => 'Pieza', 'symbol' => 'pcs'],
            ['name' => 'Par', 'symbol' => 'par'],
            ['name' => 'Docena', 'symbol' => 'doc'],
            ['name' => 'Paquete', 'symbol' => 'paq'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['symbol' => $unit['symbol']],
                ['name' => $unit['name']]
            );
        }
    }
}
