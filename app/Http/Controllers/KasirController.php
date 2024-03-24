<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KasirController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all kasirs from Models
        $kasirs = Kasir::latest()->get();

        //return view with data
        return view('kasir.index', compact('kasirs'));
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
            'nama'   => 'required',
            'alamat'   => 'required',
            'no_telp'   => 'required',
            'email'   => 'required',
          
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create kasir
        $kasir = Kasir::create([
            'nama'   => $request->nama,
            'alamat'   => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'   => $request->email
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $kasir  
        ]);
    }

    /**
     * show
     *
     * @param  mixed $kasir
     * @return void
     */
    public function show(Kasir $kasir)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data kasir',
            'data'    => $kasir  
        ]); 
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $kasir
     * @return void
     */
    public function update(Request $request, Kasir $kasir)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama'     => 'nama',
            'alamat'   => 'alamat',
            'no_telp'   => 'no_telp',
            'email'   => 'email'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create kasir
        $kasir->update([
            'nama'     => $request->nama, 
            'alamat'   => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'   => $request->email
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $kasir  
        ]);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //delete kasir by ID
        Kasir::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data kasir Berhasil Dihapus!.',
        ]); 
    }
}

