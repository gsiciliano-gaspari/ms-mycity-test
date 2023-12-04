<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea i campi necessari oltre a quelli già esistenti
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname');
            $table->string('username')->unique();
            $table->string('phone')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
