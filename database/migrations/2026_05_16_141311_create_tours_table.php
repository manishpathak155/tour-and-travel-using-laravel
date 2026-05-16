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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained('destinations')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('tour_categories')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 500);
            $table->longText('description');
            $table->json('highlights')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->longText('cost_includes')->nullable();
            $table->longText('cost_excludes')->nullable();
            $table->json('essential_info')->nullable();
            $table->json('what_to_bring')->nullable();
            $table->json('gear_list')->nullable();
            $table->unsignedSmallInteger('duration_days');
            $table->unsignedSmallInteger('duration_nights');
            $table->unsignedSmallInteger('min_group_size')->default(1);
            $table->unsignedSmallInteger('max_group_size');
            $table->unsignedSmallInteger('min_age')->default(5);
            $table->unsignedSmallInteger('max_age')->default(80);
            $table->enum('difficulty_level', ['easy', 'moderate', 'moderate_strenuous', 'strenuous', 'extreme'])->default('moderate');
            $table->enum('tour_type', ['group', 'private', 'solo', 'guaranteed'])->default('group');
            $table->string('trip_grade', 100)->nullable();
            $table->string('activities', 255)->nullable();
            $table->json('languages_offered')->nullable();
            $table->string('starts_city', 100)->nullable();
            $table->string('ends_city', 100)->nullable();
            $table->string('meeting_point', 255)->nullable();
            $table->decimal('meeting_point_lat', 10, 7)->nullable();
            $table->decimal('meeting_point_lng', 10, 7)->nullable();
            $table->integer('max_altitude_meters')->nullable();
            $table->string('best_time', 100)->nullable();
            $table->bigInteger('base_price_adult');
            $table->bigInteger('original_price_adult')->nullable();
            $table->bigInteger('base_price_child')->nullable();
            $table->bigInteger('base_price_infant')->default(0);
            $table->bigInteger('private_tour_price')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->enum('cancellation_policy', ['free', 'moderate', 'strict', 'non_refundable'])->default('moderate');
            $table->unsignedInteger('cancellation_hours')->default(48);
            $table->unsignedSmallInteger('deposit_percentage')->default(30);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_guaranteed_departure')->default(false);
            $table->boolean('is_featured')->default(true);
            $table->string('badge_text', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('total_bookings')->default(0);
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('tripadvisor_review_count')->nullable();
            $table->unsignedInteger('google_review_count')->nullable();
            $table->unsignedInteger('trustpilot_review_count')->nullable();
            $table->string('tripadvisor_url', 500)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['destination_id', 'category_id']);
            $table->index(['is_active', 'is_published']);
            $table->index(['published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
