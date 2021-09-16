<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            //$error = $validator->messages()->get('*');
            return $validator->messages()->get('*');
        } else {
            //Validator success
            return Airport::create($request->all());
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
        return new AirportResource(Airport::findOrFail($id));
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

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            $airport = Airport::find($id);
            $airport->update($request->all());
            $airport->save();
            return $airport;
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
        return Airport::destroy($id);
    }
}
