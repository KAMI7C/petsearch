<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            // Добавляем поля ТОЛЬКО если их нет
            if (!Schema::hasColumn('responses', 'guest_name')) {
                $table->string('guest_name', 100)->nullable()->after('user_id');
            }
            
            if (!Schema::hasColumn('responses', 'guest_phone')) {
                $table->string('guest_phone', 20)->nullable()->after('guest_name');
            }
            
            if (!Schema::hasColumn('responses', 'guest_social')) {
                $table->string('guest_social', 255)->nullable()->after('guest_phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_phone', 'guest_social']);
        });
    }
};