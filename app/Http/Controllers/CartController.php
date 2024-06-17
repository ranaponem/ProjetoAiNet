<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket; // Assuming Ticket model represents movie tickets

class CartController extends Controller
{

    public function show()
    {
        $cart = session('cart', []);

        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        // Fetch screening, seat, and price information from the form submission
        $screening_id = $request->input('screening_id');
        $seat_id = $request->input('seat_id');
        $price = $request->input('price');
        $redirect = $request->input('redirect');

        // Check if the same ticket (screening_id and seat_id combination) already exists in cart
        $cart = $request->session()->get('cart', []);
        foreach ($cart as $item) {
            if ($item['screening_id'] === $screening_id && $item['seat_id'] === $seat_id) {
                // Redirect back with error message if ticket already exists in cart
                return redirect()->back()->with('error', 'This ticket is already in your cart.');
            }
        }

        // Construct the cart item
        $cartItem = [
            'screening_id' => $screening_id,
            'seat_id' => $seat_id,
            'price' => $price,
        ];

        // Add the new cart item to the cart array
        $cart[] = $cartItem;

        // Store the updated cart back into session
        $request->session()->put('cart', $cart);

        // Redirect back to the previous page or a confirmation page
        if($redirect){
            return redirect()->route('movies.indexOnShow'); 
        }else{
            return redirect()->route('cart.show');   
        }
        
    }

    public function removeFromCart(Request $request)
    {
        $screening_id = $request->input('screening_id');
        $seat_id = $request->input('seat_id');

        // Retrieve cart from session
        $cart = session()->get('cart', []);

        // Loop through cart to find and remove item
        foreach ($cart as $key => $item) {
            if ($item['screening_id'] == $screening_id && $item['seat_id'] == $seat_id) {
                unset($cart[$key]); // Remove item from cart
                break; // Stop loop after removing the item
            }
        }

        // Update session with modified cart
        session()->put('cart', $cart);

        // Redirect back or return response
        return redirect()->back()->with('alert-type', 'success')
            ->with('alert-msg', 'Item removed from cart successfully.');
    }


    public function destroy(Request $request)
    {
        $request->session()->forget('cart');
        return back()->with('alert-type', 'success')
            ->with('alert-msg', 'Shopping Cart has been cleared.');
    }


    public function processCart(Request $request)
    {
        $cart = session('cart', []);

        // Check if cart is empty
        if (empty($cart)) {
            return back()->with('alert-type', 'danger')
                ->with('alert-msg', 'Cart is empty. Please add tickets to proceed.');
        }

        // Here you would typically process the cart, e.g., create orders, finalize payment, etc.

        // For demo purposes, just clear the cart after processing
        $request->session()->forget('cart');

        return redirect()->route('cart.show')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Purchase completed successfully. Thank you!');
    }
}