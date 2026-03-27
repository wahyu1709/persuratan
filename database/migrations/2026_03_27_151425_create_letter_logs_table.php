<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('letter_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // contoh: 'submitted', 'verified', 'approved', 'rejected', 'cancelled'
            $table->text('notes')->nullable(); // untuk catatan tambahan (misal: alasan tolak)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('letter_logs');
    }
};