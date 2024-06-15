<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Contracts\View\View;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index')->with('customers', $customers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return the register view
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id' => 'required|numeric|unique:customers,id',
            'nif' => 'required|string|size:9|unique:customers,nif', // NIF deve ser Ãºnico na tabela 'customers'
            'payment_type' => 'required|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'required|string|max:255',
        ]);

        try {
            // Create a new Customer instance with the validated data
            $customer = Customer::create($validatedData);

            // Redirect to the customer index page with a success message
            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            return redirect()->back()->withInput()->with('error', 'Failed to create customer. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id' => 'integer|exists:customers,id', // Ensure id exists in the customers table
            'nif' => 'string|size:9', // NIF should be exactly 9 characters
            'payment_type' => 'in:VISA,PAYPAL,MBWAY', // Validate against the enum values
            'payment_ref' => 'string|max:255', // Payment reference should be at most 255 characters
        ]);

        // Update the customer instance with the validated data
        $customer->update($validatedData);

        // Redirect to the customer index page with a success message
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }
        /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}