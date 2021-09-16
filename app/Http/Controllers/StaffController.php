<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Staff;
use App\Http\Resources\StaffResource;
use Illuminate\Support\Facades\Validator;
use DB;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StaffResource::collection(Cache::remember('staff', 60 * 60 * 24, function() {
            return Staff::all();
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
            'customer_id' => 'required',
            'hire_date' => 'required',
            'job' => 'required',
            'qualifications' => 'nullable'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            return Staff::create($request->all());
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
        return new StaffResource(Staff::findOrFail($id));
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
            'hire_date' => 'required',
            'job' => 'required',
            'qualifications' => 'nullable'
        ]);

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            $staff = Staff::find($id);
            $staff->update($request::all());
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
        return Staff::destroy($id);
    }
}
