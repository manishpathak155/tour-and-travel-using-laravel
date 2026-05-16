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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('continent');
            $table->string('country');
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->longText('description');
            $table->string('short_description', 500);
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->integer('altitude_meters')->nullable();
            $table->string('best_season', 255)->nullable();
            $table->text('climate_info')->nullable();
            $table->boolean('visa_required')->default(false);
            $table->text('visa_info')->nullable();
            $table->string('local_currency', 10)->nullable();
            $table->string('language', 100)->nullable();
            $table->string('time_zone', 50)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['continent', 'country']);
            $table->index(['is_active', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
