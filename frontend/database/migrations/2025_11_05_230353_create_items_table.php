<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ordem_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantidade')->nullable();
            $table->decimal('valor_unitario')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('itens');
    }
};