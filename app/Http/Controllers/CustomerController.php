<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends Controller
{
    use AuthorizesRequests;
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
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id' => 'required|numeric|unique:customers,id',
            'nif' => 'nullable|string|size:9|unique:customers,nif',
            'payment_type' => 'nullable|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'nullable|string|max:255',
        ]);

        try {
            // Create a new Customer instance with the validated data
            Customer::create($validatedData);

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
        $this->authorize('update', $customer); // Verifica se o utilizador pode atualizar o cliente
        return view('customers.edit')->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'nif' => 'nullable|string|size:9|unique:customers,nif,' . $customer->id,
            'payment_type' => 'nullable|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'nullable|string|max:255',
        ]);

        try {
            // Update the customer instance with the validated data
            $customer->update($validatedData);

            // Redirect to the profile edit page with a success message
            return redirect()->route('profile.edit')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., database errors)
            return redirect()->back()->withInput()->with('error', 'Failed to update customer. ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete customer. ' . $e->getMessage());
        }
    }
}
