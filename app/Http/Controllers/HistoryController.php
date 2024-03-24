<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\PesananDetail;
use Auth;
use Alert;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$pesanans = Pesanan::where('user_id', Auth::user()->id)->where('status', '!=',0)->get();
        $users = User::all();

    	return view('history.index', compact('pesanans','users'));
    }

    public function detail($id)
    {
    	$pesanan = Pesanan::where('id', $id)->first();
    	$pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        $users = User::all();


     	return view('history.detail', compact('pesanan','pesanan_details','users'));
    }
}
