<?php

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json_file = File::get('database/data/customer-data.json');
        DB::table('customers')->delete();
        $data = json_decode($json_file);
        foreach($data as $obj) {
            Customer::Create(array(
                'first_name' => $obj->first_name,
                'last_name' => $obj->last_name,
                'phone' => $obj->phone,
                'email' => $obj->email
            ));
        }
    }
}
