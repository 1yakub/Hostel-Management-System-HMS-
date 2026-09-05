<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Full demo state: two accounts, the room inventory, and a week of bookings.
     * Every seeder is idempotent so `db:seed` can run on a schedule to reset the demo.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            DemoSeeder::class,
        ]);
    }
}
