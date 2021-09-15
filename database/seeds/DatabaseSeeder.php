<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerSeeder::class);
        $this->call(AirportSeeder::class);
        $this->call(PlaneSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(FlightSeeder::class);
    }
}
