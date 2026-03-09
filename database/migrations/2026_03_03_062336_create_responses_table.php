<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // NULL для гостей
            $table->unsignedBigInteger('post_id');
            $table->string('guest_name', 100)->nullable();
            $table->string('guest_phone', 20)->nullable();
            $table->string('guest_social', 255)->nullable();
            $table->text('message');
            $table->string('preferred_time', 100)->nullable();
            $table->enum('status', ['pending', 'contacted', 'resolved'])->default('pending');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
            
            // Индексы
            $table->index('user_id');
            $table->index('post_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responses');
    }
};