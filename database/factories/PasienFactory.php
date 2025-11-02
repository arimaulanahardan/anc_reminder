<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'no_hp' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'terdaftar' => fake()->date(),
            'keterangan' => fake()->text(),
            'usia_kehailan' => fake()->numberBetween(1, 10),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
        ];
    }
}
