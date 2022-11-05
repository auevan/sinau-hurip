<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_laporan' => $this->faker->randomDigit(5),
            'tgl_dibuat' => now(),
            'jenis_laporan' => $this->faker->randomElement(['1', '2']),
            'nama_pelapor' => $this->faker->name(),
            'nama_pasien' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['1', '2']),
            'alamat' => $this->faker->city(),
            'rincian' => $this->faker->sentence(5),
            'status' => $this->faker->randomElement(['1', '2'])
        ];
    }
}
