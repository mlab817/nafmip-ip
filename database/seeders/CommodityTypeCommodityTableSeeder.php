<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\CommodityType;
use Illuminate\Database\Seeder;

class CommodityTypeCommodityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(database_path('seeders/commodities.json')));

        foreach ($json as $key => $value) {
            $commodityType = CommodityType::create([
                'name' => $key,
            ]);
            foreach ($value as $commodity) {
                $commodity = Commodity::create([
                    'name'              => $commodity->Crop,
                    'commodity_type_id' => $commodityType->id,
                ]);
            }
        }
    }
}
