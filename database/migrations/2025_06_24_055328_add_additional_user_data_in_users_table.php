<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('user_role', function (Blueprint $table) {
                $table->string('address', 255)->nullable();
                $table->string('tel', 255)->nullable();
                $table->date('birth_date')->nullable();
                $table->string('profile_picture_path')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'birth_date',
                'tel',
                'profile_picture_path',
            ]);
        });
    }
};
