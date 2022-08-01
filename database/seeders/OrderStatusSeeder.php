<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
            'status' => 'pending',
        ]);
        OrderStatus::create([
            'status' => 'approved',
        ]);
        OrderStatus::create([
            'status' => 'refused',
        ]);
    }
}
