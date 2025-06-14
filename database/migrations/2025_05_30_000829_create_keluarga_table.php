<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keluarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pegawai_id');
            $table->enum('status_pernikahan', ['belum menikah', 'menikah'])->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('nama_pasangan')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('nik_pasangan', 16)->nullable();
            $table->enum('agama', ['Islam', 'Katolik', 'Kristen', 'Hindu', 'Buddha', 'Konghucu'])->nullable();
            $table->string('no_telp_pasangan',14)->nullable();
            $table->enum('pendidikan_terakhir', ['sd', 'smp','sma','s1','s2','s3'])->nullable();
            $table->enum('status_bekerja_pasangan', ['bekerja', 'tidak bekerja'])->nullable();
            $table->enum('status_pasangan', ['hidup', 'meninggal'])->nullable();

            $table->string('nama_ayah')->nullable();
            $table->enum('status_bekerja_ayah', ['bekerja', 'tidak bekerja'])->nullable();
            $table->enum('status_ayah', ['hidup', 'meninggal'])->nullable();
            $table->string('no_telp_ayah', 14)->nullable();
            $table->string('nama_ibu')->nullable();
            $table->enum('status_bekerja_ibu', ['bekerja', 'tidak bekerja'])->nullable();
            $table->string('no_telp_ibu', 14)->nullable();
            $table->enum('status_ibu', ['hidup', 'meninggal'])->nullable();
            $table->string('alamat_ortu')->nullable();

            $table->timestamps();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluarga');
    }
};
