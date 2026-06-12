<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('premios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            $table->integer('puntos_requeridos');
            $table->string('imagen', 255)->nullable();
            $table->integer('stock')->default(0);
            $table->tinyInteger('activo')->default(1);
            $table->timestamps();
        });

        Schema::create('canjes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('premio_id')->constrained('premios')->cascadeOnDelete();
            $table->dateTime('fecha_canje');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('canjes');
        Schema::dropIfExists('premios');
    }
};
