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
        Schema::create('tour_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->unsignedSmallInteger('day_number');
            $table->string('title');
            $table->longText('description');
            $table->json('meals_included')->nullable();
            $table->string('accommodation', 255)->nullable();
            $table->enum('accommodation_type', ['teahouse', 'lodge', 'hotel', 'camping', 'luxury', 'guesthouse'])->nullable();
            $table->decimal('distance_km', 5, 1)->nullable();
            $table->decimal('walking_hours', 3, 1)->nullable();
            $table->integer('max_altitude_meters')->nullable();
            $table->integer('min_altitude_meters')->nullable();
            $table->string('activity_type', 100)->nullable();
            $table->string('transport', 100)->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['tour_id', 'day_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_itineraries');
    }
};
