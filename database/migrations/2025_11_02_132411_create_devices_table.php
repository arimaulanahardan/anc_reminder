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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Default Device');
            $table->enum('type', ['whatsapp'])->default('whatsapp');
            $table->enum('provider', ['venom', 'baileys', 'ultramsg', 'twilio'])->default('venom');
            $table->enum('status', ['disconnected','pending','qr','connected','error'])->default('disconnected');
            $table->string('phone')->nullable();
            $table->string('instance_id')->nullable();
            $table->json('credentials')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('connected_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->text('last_error')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
