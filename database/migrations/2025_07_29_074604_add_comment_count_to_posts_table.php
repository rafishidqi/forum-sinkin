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
        Schema::table('posts', function (Blueprint $table) {
            // Tambahkan kolom comment_count dengan nilai default 0
            $table->integer('comment_count')->default(0)->after('content'); // Sesuaikan posisi jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Hapus kolom comment_count jika migrasi di-rollback
            $table->dropColumn('comment_count');
        });
    }
};