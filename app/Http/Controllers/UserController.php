<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all pembelis from Models
        $users = User::latest()->get();

        //return view with data
        return view('user.index', compact('users'));
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
            'name'   => 'required',
            'alamat'   => 'required',
            'no_telp'   => 'required',
            'email'   => 'required',
          
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pembeli
        $user = User::create([
            'name'   => $request->name,
            'alamat'   => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'   => $request->email,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $user  
        ]);
    }

    /**
     * show
     *
     * @param  mixed $pembeli
     * @return void
     */
    public function show(User $user)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data user',
            'data'    => $user  
        ]); 
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $pembeli
     * @return void
     */
    public function update(Request $request, User $user)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name'     => 'name',
            'alamat'   => 'alamat',
            'no_telp'   => 'no_telp',
            'email'   => 'email'
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create pembeli
        $user->update([
            'name'     => $request->name, 
            'alamat'   => $request->alamat,
            'no_telp'   => $request->no_telp,
            'email'   => $request->email
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diudapte!',
            'data'    => $user 
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
        //delete pembeli by ID
        User::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data user Berhasil Dihapus!.',
        ]); 
    }
}

