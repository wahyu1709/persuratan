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
        Schema::create('letter_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: "Surat Keterangan Aktif Mahasiswa"
            $table->string('code')->unique(); // contoh: "aktif_kuliah"
            $table->json('required_fields')->nullable(); // array: ["nim", "semester", "tujuan_surat"]
            $table->foreignId('division_id')->constrained()->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_types');
    }
};
