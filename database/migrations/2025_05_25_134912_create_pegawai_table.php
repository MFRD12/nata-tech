<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip_pegawai')->unique(); // relasi ke users.nip
            $table->string('nama')->nullable();
            $table->string('foto')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('no_hp', 14)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif'])->nullable();
            $table->timestamps();

            $table->foreign('nip_pegawai')->references('nip')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('cascade');
            $table->foreign('divisi_id')->references('id')->on('divisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
