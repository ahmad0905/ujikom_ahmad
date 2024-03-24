<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('home.index', compact('produk'));
    }

    public function shop()
    {
        $produks = Produk::latest()->get();
        return view('home.shop', compact('produks'));
    }

    public function cart()
    {
        $produks = Produk::latest()->get();
        return view('home.cart', compact('produks'));
    }

    public function shopsingle()
    {
        $produks = Produk::latest()->get();
        return view('home.shopsingle', compact('produks'));
    }

    public function checkout()
    {
        $produks = Produk::latest()->get();
        return view('home.checkout', compact('produks'));
    }

    public function about()
    {
        $produks = Produk::latest()->get();
        return view('home.about', compact('produks'));
    }

    public function thankyou()
    {
        $produks = Produk::latest()->get();
        return view('home.thankyou', compact('produks'));
    }

    
    
}
