<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contacto>
 */
class ContactoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'celular' => $this->faker->e164PhoneNumber,
            'cargo' => $this->faker->jobTitle,
            'correo' => $this->faker->freeEmail(),
            'fecha_ultimo' => $this->faker->date,
            'fecha_proximo' => $this->faker->date,
            'cliente_id' => Cliente::all()->random()->id,
        ];
    }
}
