<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `tour_video_reviews` MODIFY `youtube_url` VARCHAR(500) NULL");
        DB::statement("ALTER TABLE `tour_video_reviews` MODIFY `youtube_video_id` VARCHAR(50) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `tour_video_reviews` MODIFY `youtube_url` VARCHAR(500) NOT NULL");
        DB::statement("ALTER TABLE `tour_video_reviews` MODIFY `youtube_video_id` VARCHAR(50) NOT NULL");
    }
};
