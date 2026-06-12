<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('registros_acciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('accion_id')->constrained('acciones_ecologicas')->cascadeOnDelete();
            $table->foreignId('dispositivo_id')->nullable()->constrained('dispositivos')->nullOnDelete();
            $table->decimal('cantidad_kg', 6, 2)->nullable();
            $table->dateTime('fecha');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('registros_acciones'); }
};
