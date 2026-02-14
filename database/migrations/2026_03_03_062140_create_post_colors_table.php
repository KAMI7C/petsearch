<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_colors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('color_id');
            $table->timestamps();
            
            $table->unique(['post_id', 'color_id']);
            
            $table->index('post_id');
            $table->index('color_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_colors');
    }
};