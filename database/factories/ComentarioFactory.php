<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comentario = $this->faker->text(30);
        static $cliente_id = 1;

        return [
            'comentario' => $comentario,
            'cliente_id' => $cliente_id++,
            'user_id' => 2,
            'created_at' => '2023-12-01 03:06:15',
            'updated_at' => '2023-12-01 03:06:15',
        ];
    }
}
