<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Airport;
use App\Http\Resources\AirportResource;
use DB;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AirportResource::collection(Cache::remember('airports', 60 * 60 * 24, function() {
            return Airport::all();
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
        //Validating
        $validator = Validator::make($request->all(), [
            'location' => 'required'
        ]);

        //Returning error string instead of an error message
        if ($validator->fails()) {
            $error = $validator->messages()->get('*');
            $response = [
                'message' => 'Validation failed.',
                'errors' => $error,
                'status' => 400
            ];
            return response($response, 400);
        }
        //Validator success
        $airport = new AirportResource(Airport::create($request->all()));

        $response = [
            'airport' => $airport,
            'message' => 'Airport created successfully.',
            'status' => '201'
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
        $raw_airport = Airport::find($id);

        //Testing if airport exsists in database
        if($raw_airport == null) {
            $response = [
                'message' => 'Airport not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        //Passing the airport object through the airport resource for formatting
        $airport = new AirportResource(Airport::find($id));
        
        $response = [
            'airport' => $airport,
            'message' => 'Airport found successfully',
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
        $validator = Validator::make($request->all(), [
            'location' => 'required'
        ]);

        //Testing data for validation
        if($validator->fails()) {
            $error = $validator->messages()->get('*');
            $response = [
                'message' => 'Airport Validation failed.',
                'errors' => $error,
                'status' => 400
            ];

            return response($response, 400);
        } else {
            $raw_airport = Airport::find($id);

            //Testing if airport is present in database
            if($raw_airport == null) {
                $response = [
                    'message' => 'Airport not found.',
                    'status' => 404
                ];

                return response($response, 404);
            }

            $airport = Airport::find($id);
            $airport->update($request->all());
            $airport->save();

            $pretty_airport = new AirportResource(Airport::find($id));

            $response = [
                'airport' => $pretty_airport,
                'message' => 'Airport updated successfully',
                'status' => 200
            ];
            return response($response, 200);
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
        $raw_airport = Airport::find($id);

        //Testing if airport is present in database
        if($raw_airport == null) {
            $response = [
                'message' => 'Airport not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        Airport::destroy($id);

        $response = [
            'message' => 'Airport found and deleted successfully.',
            'status' => 200
        ];

        return response($response, 200);
    }
}
