<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Customer;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Validator;

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
            return Customer::all();
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
            return $validation->messages()->get('*');
        } else {
            return Customer::create($request->all());
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
        return new CustomerResource(Customer::findOrFail($id));
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

        if($validator->fails()) {
            return $validator->messages()->get('*');
        } else {
            $customer = Customer::find($id);
            $customer->update($request->all());
            $customer->save();
            return $customer;
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
        return Customer::destroy($id);
    }
}
