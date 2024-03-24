<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all pembelis from Models
        $penjualans = Penjualan::with('user')->get();
        $users = User::all(); 

        //return view with data
        return view('penjualan.index', compact('penjualans', 'users'));
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'tanggal_penjualan'   => 'required',
            'total_harga'   => 'required',
            'id_user'   => 'required|exists:users,id', //validasi foreign key
            
          
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //create pembeli
        $penjualan = Penjualan::create([
            'tanggal_penjualan'   => $request->tanggal_penjualan,
            'total_harga'   => $request->total_harga,
            'id_user'   => $request->id_user,
            
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $penjualan  
        ]);
    }

   public function user()
   {
        return $this->belongsTo(User::class, 'id_user');
   }


}

