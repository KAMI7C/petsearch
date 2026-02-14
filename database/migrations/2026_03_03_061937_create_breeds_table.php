<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name', 100);
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            
            // Индексы
            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breeds');
    }
};