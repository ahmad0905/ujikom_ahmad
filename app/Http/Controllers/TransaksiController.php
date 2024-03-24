<?php
namespace App\Http\Controllers;

use App\Models\PesananDetail;
use App\Models\User;
use App\Models\Produk;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TransaksiController extends Controller
{
    public function index()
    {
        //get all transaksis from Models
        $transaksis = PesananDetail::with('produk', 'pesanan')->get();
        $produks = Produk::all();
        $users = User::all();
        $pesanans = Pesanan::all();

        //return view with data
        return view('transaksi.index', compact('transaksis', 'produks','users', 'pesanans'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'produk_id'   => 'required',
            'pesanan_id'   => 'required',
            'jumlah'  => 'required',
            'jumlah_harga'  => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create transaksi
        $transaksi = Transaksi::create([
            'produk_id'     => $request->produk_id, 
            'pesanan_id'     => $request->pesanan_id, 
            'jumlah'   => $request->jumlah,
            'jumlah_harga'     => $request->jumlah_harga, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $transaksi  
        ]);
    }

    public function show(Transaksi $transaksi)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data transaksi',
            'data'    => $transaksi  
        ]); 
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $transaksi
     * @return void
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'produk_id'   => 'required',
            'pesanan_id'   => 'required',
            'jumlah'  => 'required',
            'jumlah_harga'  => 'required'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create transaksi
        $transaksi->update([
            'produk_id'     => $request->produk_id, 
            'pesanan_id'     => $request->pesanan_id, 
            'jumlah'   => $request->jumlah,
            'jumlah_harga'     => $request->jumlah_harga, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $transaksi  
        ]);
    }

    public function destroy($id)
    {
        //delete transaksi by ID
        PesananDetail::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data transaksi Berhasil Dihapus!.',
        ]); 
    }
}
