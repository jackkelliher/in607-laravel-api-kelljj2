<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Flight;
use App\Http\Resources\FlightResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

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
            return Flight::paginate(15);
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
            $error = $validator->messages()->get('*');
            $response = [
                'message' => 'Validation failed',
                'errors' => $error,
                'status' => 400
            ];

            return response($response, 400);
        }
        

        $flight = Flight::create($request->all());
        $id = $flight->id;

        $pretty_flight = new FlightResource(Flight::find($id));

        $response = [
            'flight' => $pretty_flight,
            'message' => 'Flight created successfully.',
            'status' => 201
        ];
        
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $raw_flight = Flight::find($id);

        //Testing if flight exsists in database
        if($raw_flight == null) {
            $response = [
                'message' => 'Flight not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $flight = new FlightResource(Flight::find($id));

        $response = [
            'flight' => $flight,
            'message' => 'Flight found.',
            'status' => 200
        ];

        return response($response, 200);
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
            $errors = $validator->messages()->get('*');
            $response = [
                'message' => 'Validation failed',
                'errors' => $errors,
                'status' => 400
            ];
            return response($response, 400);
        }

        $raw_flight = Flight::find($id);

        if($raw_flight == null) {
            $response = [
                'message' => 'Flight not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $raw_flight->update($request->all());

        $pretty_flight = new FlightResource(Flight::find($id));

        $response = [
            'flight' => $pretty_flight,
            'message' => 'Flight created successfully',
            'status' => 200
        ];

        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $raw_flight = Flight::find($id);

        //Testing if flight is present in database
        if($raw_flight == null) {
            $response = [
                'message' => 'Flight not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        Flight::destroy($id);

        $response = [
            'message' => 'Flight found and deleted successfully.',
            'status' => 200
        ];

        return response($response, 200);
    }
}
