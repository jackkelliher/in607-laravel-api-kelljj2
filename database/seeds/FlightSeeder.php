<?php

use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_file = File::get('database/data/flight-data.json');
        DB::table('flights')->delete();
        $data = json_decode($json_file);
        foreach($data as $obj) {
            Flight::Create(array(
                'plane_id' => $obj->plane_id,
                'pilot_id' => $obj->pilot_id,
                'departure_airport' => $obj->departure_airport,
                'arrival_airport' => $obj->arrival_airport,
                'departure_date' => $obj->departure_date,
                'arrival_date' => $obj->arrival_date,
            ));
        }
    }
}
