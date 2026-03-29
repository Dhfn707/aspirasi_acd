<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAspirasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('References user table from absen_karyawan database');
            $table->unsignedBigInteger('jabatan_id')->nullable()->comment('References jabatan table from absen_karyawan database');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi', 'Urgent'])->default('Sedang');
            $table->text('aspirasi');
            $table->enum('status', ['Belum Dibaca', 'Dibaca', 'Ditanggapi', 'Selesai'])->default('Belum Dibaca');
            $table->text('tanggapan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aspirasis');
    }
}
