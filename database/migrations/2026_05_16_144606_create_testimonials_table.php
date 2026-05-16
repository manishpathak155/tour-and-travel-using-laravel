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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->nullable()->constrained('reviews')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('avatar')->nullable();
            $table->text('quote');
            $table->string('tour_taken', 255)->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->enum('platform', ['website', 'tripadvisor', 'google', 'trustpilot'])->default('website');
            $table->boolean('is_published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['platform', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
