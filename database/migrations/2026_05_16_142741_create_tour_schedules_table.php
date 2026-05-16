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
        Schema::create('tour_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->cascadeOnDelete();
            $table->date('departure_date');
            $table->date('return_date');
            $table->unsignedSmallInteger('total_seats');
            $table->unsignedSmallInteger('booked_seats')->default(0);
            $table->bigInteger('price_override_adult')->nullable();
            $table->bigInteger('price_override_child')->nullable();
            $table->bigInteger('original_price_override')->nullable();
            $table->enum('status', ['open', 'guaranteed', 'full', 'closed', 'cancelled'])->default('open');
            $table->text('notes')->nullable();
            $table->boolean('is_guaranteed')->default(false);
            $table->timestamps();

            $table->index(['tour_id', 'departure_date']);
            $table->index(['status', 'is_guaranteed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_schedules');
    }
};
