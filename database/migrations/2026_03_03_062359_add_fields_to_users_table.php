<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('social', 255)->nullable()->after('phone');
            $table->enum('role', ['user', 'admin'])->default('user')->after('social');
            $table->boolean('banned')->default(false)->after('role');
            $table->text('ban_reason')->nullable()->after('banned');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'social', 'role', 'banned', 'ban_reason']);
        });
    }
};