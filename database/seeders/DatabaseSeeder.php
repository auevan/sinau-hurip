<?php

namespace Database\Seeders;
use App\Models\Laporan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Laporan::insert([
            'id_laporan' => '2',
            'tgl_dibuat' => now(),
            'jenis_laporan' => '1',
            'nama_pelapor' => 'w',
            'nama_pasien' => 'abc',
            'jenis_kelamin' => '1',
            'gambar' => 'gambar_1.jpg',
            'alamat' => 'w',
            'telepon' => '082225142333',
            'rincian' => 'sss',
            'status' => '0'
            ]);

            
    }
}
