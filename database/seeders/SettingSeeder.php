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
        Setting::set('store_name', 'Moda Urbana Colombia');
        Setting::set('store_address', 'Cra. 15 #85-20, Local 12, Bogotá, Colombia');
        Setting::set('store_phone', '3105551234');
        Setting::set('opening_balance_date', now()->startOfYear()->toDateString());
        Setting::set('opening_balance_amount', '5000000');
        Setting::set('currency_symbol', '$');
        Setting::set('currency_position', 'left');
        Setting::set('currency_fraction_digits', '0');
        Setting::set('currency_thousand_separator', '.');
        Setting::set('currency_decimal_separator', ',');
    }
}
