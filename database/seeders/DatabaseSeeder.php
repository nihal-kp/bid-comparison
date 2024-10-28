<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('bid_comparisons')->insert([
            [
                'supplier_name' => 'Al Ain Plastic Industry',
                'currency' => 'AED',
                'payment_term' => 'Against job completion',
                'delivery_period' => '6 months',
                'unit_cost' => 60000.00,
                'vat' => 5,
                'awarded_line' => '1.1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_name' => 'Abdulrahman Salem Al Selaiem Est',
                'currency' => 'AED',
                'payment_term' => 'Advance',
                'delivery_period' => '6 months',
                'unit_cost' => 680000.00,
                'vat' => 5,
                'awarded_line' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'supplier_name' => 'Accurate Meezan Trading LLC',
                'currency' => 'AED',
                'payment_term' => 'CDC',
                'delivery_period' => '5-7 months',
                'unit_cost' => 120000.00,
                'vat' => 5,
                'awarded_line' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
