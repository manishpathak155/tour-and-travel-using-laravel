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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('nationality', 100)->nullable()->after('phone');
            $table->string('passport_number', 50)->nullable()->after('nationality');
            $table->date('date_of_birth')->nullable()->after('passport_number');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->boolean('is_active')->default(true)->after('gender');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
            $table->string('referral_code', 20)->nullable()->unique()->after('last_login_ip');
            $table->foreignId('referred_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->after('referral_code');
            $table->integer('loyalty_points')->default(0)->after('referred_by');
            $table->string('affiliate_code', 20)->nullable()->unique()->after('loyalty_points');
            $table->softDeletes()->after('affiliate_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn([
                'phone',
                'nationality',
                'passport_number',
                'date_of_birth',
                'gender',
                'is_active',
                'last_login_at',
                'last_login_ip',
                'referral_code',
                'referred_by',
                'loyalty_points',
                'affiliate_code',
                'deleted_at',
            ]);
        });
    }
};
