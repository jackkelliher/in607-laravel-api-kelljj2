<?php

use Illuminate\Database\Seeder;
use App\Models\Plane;

class PlaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_file = File::get('database/data/plane-data.json');
        DB::table('planes')->delete();
        $data = json_decode($json_file);
        foreach($data as $obj) {
            Plane::Create(array(
                'model' => $obj->model,
                'capacity' => $obj->capacity,
                'speed' => $obj->speed,
                'airport_id' => $obj->airport_id
            ));
        }
    }
}
