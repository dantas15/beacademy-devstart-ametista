<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            'name' => 'credit_card',
            'api_type' => 'card',
        ]);
        PaymentMethod::create([
            'name' => 'boleto',
            'api_type' => 'ticket'
        ]);
    }
}
