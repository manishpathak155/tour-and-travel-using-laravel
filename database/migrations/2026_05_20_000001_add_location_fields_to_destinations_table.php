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
        Schema::table('destinations', function (Blueprint $table): void {
            $table->string('state')->nullable()->after('country');
            $table->string('zone')->nullable()->after('state');
            $table->string('district')->nullable()->after('zone');

            $table->index(['country', 'state', 'region']);
            $table->index(['country', 'zone', 'district']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table): void {
            $table->dropIndex(['country', 'state', 'region']);
            $table->dropIndex(['country', 'zone', 'district']);

            $table->dropColumn(['state', 'zone', 'district']);
        });
    }
};