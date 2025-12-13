<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('peserta_pendaftarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kalangan_id')->constrained('kalangans')->cascadeOnDelete();
            $table->foreignId('iklan_id')->constrained('iklans')->cascadeOnDelete();

            $table->string('nama_peserta');
            $table->string('nama_kalangan');
            $table->string('nama_iklan');
            $table->decimal('biaya_pendaftaran', 15, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peserta_pendaftarans');
    }
};
