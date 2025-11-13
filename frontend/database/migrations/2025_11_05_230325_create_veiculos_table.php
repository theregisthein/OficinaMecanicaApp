<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->text('marca')->nullable();
            $table->text('modelo')->nullable();
            $table->text('placa')->nullable();
            $table->date('ano')->nullable();
            $table->text('cor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('veiculos');
    }
};