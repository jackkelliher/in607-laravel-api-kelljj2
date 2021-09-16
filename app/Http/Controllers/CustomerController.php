<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerResource::collection(Cache::remember('customers', 60 * 60 * 24, function() {
            return Customer::paginate(15);
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
        //validation
        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'nullable'
        ]);

        //If validator fails, return the errors that caused it instead of throwing an error
        if($validation->fails()) {
            $errors = $validation->messages()->get('*');
            $response = [
                'message' => 'Validation failed',
                'errors' => $errors,
                'status' => 400
            ];

            return response($response, 400);
        }
        
        $customer = Customer::create($request->all());
        $id = $customer->id;

        $pretty_customer = new CustomerResource(Customer::find($id));

        $response = [
            'customer' => $pretty_customer,
            'message' => 'Customer created successfully',
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
        $raw_customer = Customer::find($id);

        //Testing if customer exsists in database
        if($raw_customer == null) {
            $response = [
                'message' => 'Customer not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $customer = new CustomerResource(Customer::find($id));

        $response = [
            'customer' => $customer,
            'message' => 'Customer found.',
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
        //validation
        $validator = Validator::make($request->all(), [
            'first_name',
            'last_name',
            'phone',
            'email'
        ]);

        //If validation fails
        if($validator->fails()) {
            $errors = $validator->messages()->get('*');
            $response = [
                'message' => 'Validation failed.',
                'errors' => $errors,
                'status' => 400
            ];

            return response($response, 400);
        }
        $raw_customer = Customer::find($id);

        if($raw_customer == null) {
            $response = [
                'message' => 'Customer not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        $raw_customer->update($request->all());
        $raw_customer->save();

        //Using the resource to provide a better looking response
        $customer = new CustomerResource(Customer::find($id));

        $response = [
            'customer' => $customer,
            'message' => 'Customer found and updated.',
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
        $raw_customer = Customer::find($id);

        //Testing if customer is present in database
        if($raw_customer == null) {
            $response = [
                'message' => 'Customer not found.',
                'status' => 404
            ];

            return response($response, 404);
        }

        Customer::destroy($id);

        $response = [
            'message' => 'Customer found and deleted successfully.',
            'status' => 200
        ];

        return response($response, 200);
    }
}
