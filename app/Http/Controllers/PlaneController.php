<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Plane;
use App\Http\Resources\PlaneResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use DB;

class PlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PlaneResource::collection(Cache::remember('planes', 60 * 60 * 24, function() {
            return Plane::paginate(15);
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
            'model' => 'required',
            'capacity' => 'required',
            'speed' => 'required',
            'airport_id' => 'required'
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
        

        $plane = Plane::create($request->all());
        $id = $plane->id;

        $pretty_plane = new PlaneResource(Plane::find($id));

        $response = [
            'plane' => $pretty_plane,
            'message' => 'Plane created successfully.',
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
        $raw_plane = Plane::find($id);

        //Testing if plane exsists in database
        if($raw_plane == null) {
            $response = [
                'message' => 'Plane not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $plane = new PlaneResource(Plane::find($id));

        $response = [
            'plane' => $plane,
            'message' => 'Plane found.',
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
            'model',
            'speed',
            'capacity',
            'airport_id',
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

        $raw_plane = Plane::find($id);

        if($raw_plane == null) {
            $response = [
                'message' => 'Plane not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $raw_plane->update($request->all());

        $pretty_plane = new PlaneResource(Plane::find($id));

        $response = [
            'plane' => $pretty_plane,
            'message' => 'Plane created successfully',
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
        $raw_plane = Plane::find($id);

        //Testing if plane is present in database
        if($raw_plane == null) {
            $response = [
                'message' => 'Plane not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        Plane::destroy($id);

        $response = [
            'message' => 'Plane found and deleted successfully.',
            'status' => 200
        ];

        return response($response, 200);
    }
}
