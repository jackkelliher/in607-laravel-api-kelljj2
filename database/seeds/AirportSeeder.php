<?php

use Illuminate\Database\Seeder;
use App\Models\Airport;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_file = File::get('database/data/airport-data.json');
        DB::table('airports')->delete();
        $data = json_decode($json_file);
        foreach($data as $obj) {
            Airport::Create(array(
                'location' => $obj->location,
            ));
        }
    }
}
