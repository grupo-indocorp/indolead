<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movistar>
 */
class MovistarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estado_wick' => $this->faker->text(5),
            'linea_claro' => $this->faker->randomDigit,
            'linea_entel' => $this->faker->randomDigit,
            'linea_bitel' => $this->faker->randomDigit,
            'ejecutivo_salesforce' => $this->faker->text(8),
            'agencia' => $this->faker->company,
            'clientetipo_id' => 1,
            'cliente_id' => Cliente::all()->random()->id,
        ];
    }
}
