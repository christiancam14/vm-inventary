<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::set('store_name', 'VM');
        Setting::set('store_address', 'Cra. 8 #6-35, Barbosa, Santander, Colombia');
        Setting::set('store_phone', '320 8344505');
        Setting::set('opening_balance_date', '2026-01-01');
        Setting::set('opening_balance_amount', '5000000');
        Setting::set('currency_symbol', '$');
        Setting::set('currency_position', 'left');
        Setting::set('currency_fraction_digits', '0');
        Setting::set('currency_thousand_separator', '.');
        Setting::set('currency_decimal_separator', ',');
    }
}
