<?php

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_file = File::get('database/data/staff-data.json');
        DB::table('staff')->delete();
        $data = json_decode($json_file);
        foreach($data as $obj) {
            Staff::Create(array(
                'customer_id' => $obj->customer_id,
                'hire_date' => $obj->hire_date,
                'job' => $obj->job,
                'airport_id' => $obj->airport_id,
                'qualifications' => $obj->qualifications
            ));
        }
    }
}
