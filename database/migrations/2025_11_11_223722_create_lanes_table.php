<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lanes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ex: Top, Jungle, Mid, ADC, Support
            $table->string('description')->nullable(); // Ex: "Rota superior - tanques e duelistas"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lanes');
    }
};
