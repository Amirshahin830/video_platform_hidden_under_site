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
        Schema::table('videos', function (Blueprint $table) {
            $table->string('path_360p')->nullable();
            $table->string('path_720p')->nullable();
            $table->string('path_1080p')->nullable();
            $table->enum('processing_status', ['pending', 'processing', 'done', 'failed'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            //
        });
    }
};
