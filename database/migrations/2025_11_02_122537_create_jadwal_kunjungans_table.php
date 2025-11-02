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
        Schema::create('jadwal_kunjungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->time('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('pesan_pengingat')->nullable();
            $table->enum('frekuensi_pengingat', ['sekali', 'mingguan', 'dua_minggu_sekali', 'bulanan'])->default('sekali');
            $table->boolean('pengingat_otomatis')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kunjungans');
    }
};
