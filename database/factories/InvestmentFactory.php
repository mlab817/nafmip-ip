<?php

namespace Database\Factories;

use App\Models\Commodity;
use App\Models\Intervention;
use App\Models\Investment;
use App\Models\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->count() ? User::all()->random() : User::factory()->create();
        $long = $this->faker->randomFloat(4, 117, 126);
        $lat = $this->faker->randomFloat(4, 5, 18);

        return [
            'commodity_id'      => Commodity::all()->random()->id,
            'title'             => $this->faker->sentence,
            'intervention_id'   => Intervention::all()->random()->id,
            'description'       => $this->faker->paragraph,
            'quantity'          => $this->faker->numberBetween(1, 1000),
            'cost'              => $this->faker->numberBetween(1, 30) * 1000000,
            'location_map'      => new Point($lat, $long),
            'proponent'         => $this->faker->numberBetween(1, 100) . $this->faker->randomElement(['farmers','fisherfolk', 'farm laborers','cooperatives','farmers/fishers groups','LGUs']),
            'beneficiaries'     => $this->faker->sentence,
            'justification'     => $this->faker->paragraph,
            'user_id'           => $user->id,
        ];
    }
}
