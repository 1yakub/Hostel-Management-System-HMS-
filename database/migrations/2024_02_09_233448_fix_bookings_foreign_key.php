<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['guest_id']);

            // Add new foreign key referencing users table
            $table->foreign('guest_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['guest_id']);

            // Restore original foreign key
            $table->foreign('guest_id')
                ->references('id')
                ->on('guests')
                ->onDelete('cascade');
        });
    }
};
