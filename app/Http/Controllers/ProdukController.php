<?php

namespace App\Http\Controllers;

use App\Models\Produk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProdukController extends Controller
{
    public function index()
    {
        //get all produks from Models
        $produks = Produk::latest()->get();
        

        //return view with data
        return view('produk.index', compact('produks'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            
            'nama'     => 'required',
            'deskripsi'     => 'required',
            'harga'     => 'required',
            'stok'   => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        else{

        //upload image
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('image'), $imageName);
        
    
        $produk = Produk::create([
             
            'nama'     => $request->nama, 
            'deskripsi'   => $request->deskripsi,
            'harga'   => $request->harga,
            'stok'   => $request->stok,
            'image'   => $imageName
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $produk  
        ]);
    }
    }

    public function show(Produk $produk)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data produk',
            'data'    => $produk  
        ]); 
    }
    
    public function update(Request $request, Produk $produk)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        
        'nama' => 'required',
        'deskripsi' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan dengan kebutuhan
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Proses update produk
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('image'), $imageName);
        $produk->image = $imageName;
    }

    
    $produk->nama = $request->nama;
    $produk->deskripsi = $request->deskripsi;
    $produk->harga = $request->harga;
    $produk->stok = $request->stok;
    $produk->save();

    return response()->json([
        'success' => true,
        'message' => 'Data Berhasil Diupdate!',
        'data' => $produk
    ]);
}


    public function destroy($id)
    {
        //delete produk by ID
        Produk::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data produk Berhasil Dihapus!.',
        ]); 
    }
}
