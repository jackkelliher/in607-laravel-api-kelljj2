<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Plane;
use App\Http\Resources\PlaneResource;
use Illuminate\Support\Facades\Validator;
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
            return Plane::all();
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
            'speed' => 'required',
            'capacity' => 'required'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            return Plane::create($request->all());
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
        return new PlaneResource(Plane::findOrFail($id));
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
            'capacity'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            $plane = Plane::find($id);
            $plane->update($request->all());
            return $plane;
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
        return Plane::destroy($id);
    }
}
