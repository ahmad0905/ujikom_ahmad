<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;
class CheckoutController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function checkout()
    {
        $checkout = Checkout::latest()->get();
        return view('home.checkout', compact('checkout'));
    }
}

