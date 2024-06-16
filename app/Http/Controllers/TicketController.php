<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $tickets = Ticket::all();
        return view('tickets.index')->with('tickets', $tickets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Retrieve screening based on the request
        $screening = Screening::findOrFail($request->screening);
        $seat = Seat::findOrFail($request->seat);

        // Retrieve configuration for pricing
        $configuration = Configuration::firstOrFail();

        // Calculate price based on user and configuration
        $price = $this->calculatePrice($configuration);

        return view('tickets.create', [
            'screening' => $screening,
            'seat' => $seat,
            'price' => $price,
        ]);
    }

    private function calculatePrice(Configuration $configuration)
    {
        $basePrice = $configuration->ticket_price;
        $discount = 0;

        // Check if user is authenticated and apply discount if applicable
        if (Auth::check()) {
            $discount = $configuration->registered_customer_ticket_discount;
        }

        // Calculate final price after applying discount
        $finalPrice = $basePrice - $discount;

        return $finalPrice;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
