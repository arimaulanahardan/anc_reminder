<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pasien;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JadwalKunjungan>
 */
class JadwalKunjunganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => Pasien::factory(),
            'tanggal_kunjungan' => fake()->date(),
            'waktu' => fake()->time(),
            'lokasi' => fake()->address(),
            'pesan_pengingat' => fake()->sentence(),
            'frekuensi_pengingat' => fake()->randomElement(['sekali', 'mingguan', 'dua_minggu_sekali', 'bulanan']),
            'pengingat_otomatis' => fake()->boolean(),
        ];
    }
}
