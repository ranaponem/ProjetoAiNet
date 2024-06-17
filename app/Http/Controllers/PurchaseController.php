<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Services\Payment;

class PurchaseController extends Controller
{
    use AuthorizesRequests;

    public function show(Purchase $purchase)
    {
        // Ensure the purchase belongs to the authenticated user
        $this->authorize('view', $purchase);

        // Load the related tickets
        $purchase->load('tickets');

        return view('purchases.show', compact('purchase'));
    }

    public function index()
    {
        $query = Purchase::query();
        // Fetch all purchases ordered by the latest
        if(auth()->user()->type==='A'){
            $query->orderBy('created_at', 'desc');
        }else{
            $user = auth()->user();
            $query->where('customer_id', $user->customer->id)->orderBy('created_at', 'desc');
        }

        $purchases = $query->paginate(15)->withQueryString();

        return view('purchases.index', compact('purchases'));
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
            'nif' => 'nullable|string|size:9',
            'payment_type' => 'nullable|in:VISA,PAYPAL,MBWAY',
            'payment_ref' => 'required|string|max:255',
            'receipt_pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $cart = json_decode($request->input('cart'), true);
        if ($request->payment_type == 'VISA') {
            //because we don't store de cvc code we just send a valid one
            if (!Payment::payWithVisa($request->payment_ref, 177)) {
                return redirect()->back()->withInput()->with('error', 'Failed to create customer. Invalid payment data.');
            }
        }
        //do the same with paypal and mbway
        if ($request->payment_type == 'PAYPAL') {
            if (!Payment::payWithPaypal($request->payment_ref)) {
                return redirect()->back()->withInput()->with('error', 'Failed to create customer. Invalid payment data.');
            }
        }
        if ($request->payment_type == 'MBWAY') {
            if (!Payment::payWithMBway($request->payment_ref)) {
                return redirect()->back()->withInput()->with('error', 'Failed to create customer. Invalid payment data.');
            }
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
        ]);

        // Create tickets associated with this purchase
        $purchase->createTicketsFromCart($cart);

        session()->forget('cart');

        // Redirect back or to a confirmation page
        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }
}