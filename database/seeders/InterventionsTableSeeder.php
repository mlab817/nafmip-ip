<?php

namespace Database\Seeders;

use App\Models\Intervention;
use App\Models\InvestmentType;
use Illuminate\Database\Seeder;

class InterventionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(database_path('seeders/interventions.json')), true);

        foreach ($json as $intervention) {
            $commodityGroup = $intervention['Commodity Group'];
            $function = $intervention['Function'];
            if ($function) {
                $investmentType = InvestmentType::create([
                    'name' => $commodityGroup . ' - ' . $function,
                ]);
                $interventions = explode(';', $intervention['Intervention']);

                if ($interventions) {
                    foreach ($interventions as $intervention2) {
                        Intervention::create([
                            'name' => $intervention2,
                            'investment_type_id' => $investmentType->id
                        ]);
                    }
                }
            }
        }
    }
}
