<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Flight;
use App\Http\Resources\FlightResource;
use Illuminate\Support\Facades\Validator;
use DB;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FlightResource::collection(Cache::remember('flights', 60 * 60 * 12, function() {
            return Flight::all();
        }));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $validator = Validator::make($request->all(), [
            'departure_date' => 'required',
            'arrival_date' => 'required',
            'departure_airport' => 'required',
            'arrival_airport' => 'required',
            'pilot_id' => 'required',
            'plane_id' => 'required'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            return Flight::create($request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new FlightResource(Flight::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
                //Validation
        $validator = Validator::make($request->all(), [
            'departure_date',
            'arrival_date',
            'departure_airport',
            'arrival_airport',
            'pilot_id',
            'plane_id'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            return Flight::create($request->all());
            $flight = Flight::find($id);
            $flight->update($request->all());
            return $flight;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Flight::destroy($id);
    }
}
