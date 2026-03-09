<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['lost', 'found']);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('breed_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('name', 100)->nullable();
            $table->enum('gender', ['male', 'female', 'unknown'])->default('unknown');
            $table->enum('age', ['щенок', 'взрослый'])->nullable();
            $table->text('description')->nullable();
            $table->date('lost_date');
            $table->string('photo', 255)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
            
            // Индек для быстр поиск
            $table->index('user_id');
            $table->index('category_id');
            $table->index('breed_id');
            $table->index('district_id');
            $table->index(['status', 'is_active']);
            $table->index('lost_date');
        });
        

        DB::statement('ALTER TABLE posts ADD FULLTEXT search_idx(name, description)');
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};