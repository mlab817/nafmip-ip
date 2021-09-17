<?php

namespace Database\Seeders;

use App\Models\Investment;
use Illuminate\Database\Seeder;

class InvestmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Investment::factory()->count(1000)->create();
    }
}
