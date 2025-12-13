<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peserta_pendaftarans', function (Blueprint $table) {
            $table->foreignId('webinar_id')
                ->after('iklan_id')
                ->constrained('webinars')
                ->cascadeOnDelete();

            $table->string('nama_webinar')->after('nama_iklan');
        });
    }

    public function down(): void
    {
        Schema::table('peserta_pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['webinar_id']);
            $table->dropColumn(['webinar_id', 'nama_webinar']);
        });
    }
};
