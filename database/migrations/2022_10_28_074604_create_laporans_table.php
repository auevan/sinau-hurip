<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->string('tgl_dibuat');
            $table->string('id_laporan')->unique();
            $table->string('jenis_laporan');
            $table->string('nama_pelapor');
            $table->string('nama_pasien');
            $table->string('jenis_kelamin');
            $table->string('gambar')->nullable();
            $table->string('alamat');
            $table->string('telepon');
            $table->string('rincian');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporans');
    }
}
