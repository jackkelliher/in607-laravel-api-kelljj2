<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Staff;
use App\Http\Resources\StaffResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
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
            'airport_id' => 'required',
            'hire_date' => 'required',
            'job' => 'required',
            'qualifications' => 'required'
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
        

        $staff = Staff::create($request->all());
        $id = $staff->id;

        $pretty_staff = new StaffResource(Staff::find($id));

        $response = [
            'staff' => $pretty_staff,
            'message' => 'Staff created successfully.',
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
        $raw_staff = Staff::find($id);

        //Testing if staff member exsists in database
        if($raw_staff == null) {
            $response = [
                'message' => 'Staff member not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $staff = new StaffResource(Staff::find($id));

        $response = [
            'staff' => $staff,
            'message' => 'Staff memeber found.',
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
            'customer_id',
            'airport_id',
            'job',
            'qualifications',
            'hire_date'
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

        $raw_staff = staff::find($id);

        if($raw_staff == null) {
            $response = [
                'message' => 'Staff not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $raw_staff->update($request->all());

        $pretty_staff = new StaffResource(Staff::find($id));

        $response = [
            'staff' => $pretty_staff,
            'message' => 'Staff created successfully',
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
        $raw_staff = Staff::find($id);

        //Testing if staff is present in database
        if($raw_staff == null) {
            $response = [
                'message' => 'Staff not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        Staff::destroy($id);

        $response = [
            'message' => 'Staff found and deleted successfully.',
            'status' => 200
        ];

        return response($response, 200);
    }
}
