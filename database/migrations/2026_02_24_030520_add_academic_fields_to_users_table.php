<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('study_level')->nullable(); // Jenjang: S1, Profesi, D3, dst.
            $table->tinyInteger('semester')->nullable(); // Semester: 1–14
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['study_level', 'semester']);
        });
    }
};