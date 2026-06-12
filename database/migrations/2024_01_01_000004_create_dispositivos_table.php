<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('ubicacion', 255);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 255)->nullable();
            $table->enum('estado', ['activo', 'mantenimiento', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('dispositivos'); }
};
