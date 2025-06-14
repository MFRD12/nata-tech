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
        Schema::create('anak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('keluarga_id');
            $table->string('nama');
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->enum('status_bekerja', ['bekerja', 'tidak bekerja','pelajar'])->nullable();
            $table->enum('status_hidup', ['hidup', 'meninggal'])->nullable();
            $table->enum('status_anak', ['kandung', 'tiri', 'angkat'])->nullable();
            $table->boolean('status_tanggungan')->default(true); 
            $table->enum('status_pernikahan', ['belum menikah', 'menikah'])->nullable();
            $table->timestamps();
            $table->foreign('keluarga_id')->references('id')->on('keluarga')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
