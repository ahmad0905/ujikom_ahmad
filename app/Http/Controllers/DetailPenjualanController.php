<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DetailPenjualanController extends Controller
{
    public function index()
    {
        //get all pembelis from Models
        $detail_penjualan = DetailPenjualan::with('detail_penjualan', 'produk')->get();
      
        $produks = Produk::all();


        //return view with data
        return view('detailpenjualan.index', compact('detail_penjualan' , 'produks'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_penjualan'     => 'required',
            'id_produk'     => 'required',
            'jumlah_produk'     => 'required',
            'subtotal'     => 'required',



        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
            // return response()->json(['errors' => ['email' => ['Email sudah ada']]], 422);
        }

        

        //create pembeli
        $detail_penjualan = detailpenjualan::create([
            'id_penjualan'     => $request->id_penjualan, 
            'id_produk'     => $request->id_produk, 
            'jumlah_produk'   => $request->jumlah_produk,
            'subtotal'   => $request->subtotal

           
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $detail_penjualan  
        ]);
    }

    public function show(detailpenjualan $detail_penjualan)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data pelanggan',
            'data'    => $detail_penjualan  
        ]); 
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $pembeli
     * @return void
     */
    public function update(Request $request, detailpenjualan $detail_penjualan)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'id_penjualan'     => 'required',
            'id_produk'     => 'required',
            'jumlah_produk'   => 'required',
            'subtotal'   => 'required',


        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pembeli
        $detail_penjualan->update([
            'id_penjualan'     => $request->id_penjualan, 
            'id_produk'     => $request->id_produk, 
            'jumlah_produk'   => $request->jumlah_produk,
            'subtotal'   => $request->subtotal


        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $detail_penjualan  
        ]);
    }

    public function destroy($id)
    {
        //delete pembeli by ID
        detailpenjualan::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data penjualan Berhasil Dihapus!.',
        ]); 
    }
}
