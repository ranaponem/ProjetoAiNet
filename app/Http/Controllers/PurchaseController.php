<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        // Fetch all purchases
        $purchases = Purchase::orderBy('created_at', 'desc')->get();

        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        // Return a view to create a new purchase
        return view('purchases.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'date' => 'required|date',
            'total_price' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'nif' => 'nullable|string|max:20',
            'payment_type' => 'required|string|max:50',
            'payment_ref' => 'required|string|max:100',
            'receipt_pdf' => 'nullable|file|mimes:pdf|max:2048', // Assuming receipt PDF upload
        ]);

        // Handle receipt PDF file upload if present
        if ($request->hasFile('receipt_pdf')) {
            $file = $request->file('receipt_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('receipts', $filename); // Store in storage/app/receipts directory
        } else {
            $filename = null;
        }

        // Create a new Purchase instance
        $purchase = Purchase::create([
            'customer_id' => $validated['customer_id'],
            'date' => $validated['date'],
            'total_price' => $validated['total_price'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'nif' => $validated['nif'],
            'payment_type' => $validated['payment_type'],
            'payment_ref' => $validated['payment_ref'],
            'receipt_pdf_filename' => $filename,
        ]);

        // Redirect back or to a confirmation page
        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function show($id)
    {
        // Fetch a single purchase by ID
        $purchase = Purchase::findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }

    // Other methods like edit, update, delete can be added based on your application needs
}

