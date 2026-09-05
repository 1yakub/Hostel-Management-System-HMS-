<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The 2024 schema pointed bookings.guest_id at users, so desk registered guests could never
 * be booked and web guests had no guest record. Now: a guest row is the one thing a booking
 * points at, and a guest may optionally belong to a user account (web signups).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->unique()->after('id')->constrained()->nullOnDelete();
            $table->string('email', 255)->nullable()->after('name');
            $table->string('phone', 20)->nullable()->change();
            $table->string('id_number', 50)->nullable()->change();
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['guest_id']);
            $table->foreign('guest_id')->references('id')->on('guests')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['guest_id']);
            $table->foreign('guest_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('email');
            $table->string('phone', 20)->nullable(false)->change();
            $table->string('id_number', 50)->nullable(false)->change();
        });
    }
};
