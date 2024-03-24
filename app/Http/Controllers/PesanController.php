<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
    	$produk = Produk::where('id', $id)->first();

    	return view('pesan.index', compact('produk'));
    }

    public function pesan(Request $request, $id)
    {	
    	$produk = Produk::where('id', $id)->first();
    	$tanggal = Carbon::now();

    	//validasi apakah melebihi stok
    	if($request->jumlah_pesan > $produk->stok)
    	{
    		return redirect('pesan/'.$id);
    	}

    	//cek validasi
    	$cek_penjualan = Penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	//simpan ke database penjualan
    	if(empty($cek_penjualan))
    	{
    		$penjualan = new Penjualan;
	    	$penjualan->user_id = Auth::user()->id;
	    	$penjualan->tanggal = $tanggal;
	    	$penjualan->status = 0;
	    	$penjualan->jumlah_harga = 0;
            $penjualan->kode = mt_rand(100, 999);
	    	$penjualan->save();
    	}
    	

    	//simpan ke database penjualan detail
    	$penjualan_baru = penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();

    	//cek penjualan detail
    	$cek_detail_penjualan = DetailPenjualan::where('produk_id', $produk->id)->where('penjualan_id', $penjualan_baru->id)->first();
    	if(empty($cek_detail_penjualan))
    	{
    		$detail_penjualan = new DetailPenjualan;
	    	$detail_penjualan->produk_id = $produk->id;
	    	$detail_penjualan->penjualan_id = $penjualan_baru->id;
	    	$detail_penjualan->jumlah = $request->jumlah_pesan;
	    	$detail_penjualan->jumlah_harga = $produk->harga*$request->jumlah_pesan;
	    	$detail_penjualan->save();
    	}else 
    	{
    		$detail_penjualan = DetailPenjualan::where('produk_id', $produk->id)->where('penjualan_id', $penjualan_baru->id)->first();

    		$detail_penjualan->jumlah = $detail_penjualan->jumlah+$request->jumlah_pesan;

    		//harga sekarang
    		$harga_detail_penjualan_baru = $produk->harga*$request->jumlah_pesan;
	    	$detail_penjualan->jumlah_harga = $detail_penjualan->jumlah_harga+$harga_detail_penjualan_baru;
	    	$detail_penjualan->update();
    	}

    	//jumlah total
    	$penjualan = penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();
    	$penjualan->jumlah_harga = $penjualan->jumlah_harga+$produk->harga*$request->jumlah_pesan;
    	$penjualan->update();
    	
        // Alert::success('penjualan Sukses Masuk Keranjang', 'Success');
    	return redirect('cart');

    }

    public function updateQuantity(Request $request, $id)
    {
        $detailPenjualan = DetailPenjualan::findOrFail($id);
        $detailPenjualan->jumlah = $request->jumlah;
        $detailPenjualan->jumlah_harga = $request->jumlah * $detailPenjualan->produk->harga;
        $detailPenjualan->save();

        // Perbarui total harga di penjualan
        $penjualan = Penjualan::findOrFail($detailPenjualan->penjualan_id);
        $totalHarga = DetailPenjualan::where('penjualan_id', $penjualan->id)->sum('jumlah_harga');
        $penjualan->jumlah_harga = $totalHarga;
        $penjualan->save();

        return response()->json(['success' => true]);
    }

    public function check_out()
    {
        $penjualan = penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();
 	$detail_penjualans = [];
        if(!empty($penjualan))
        {
            $detail_penjualans = DetailPenjualan::where('penjualan_id', $penjualan->id)->get();

        }
        
        return view('pesan.cart', compact('penjualan', 'detail_penjualans'));
    }

    public function delete($id)
    {
        $detail_penjualan = DetailPenjualan::where('id', $id)->first();

        $penjualan = penjualan::where('id', $detail_penjualan->penjualan_id)->first();
        $penjualan->jumlah_harga = $penjualan->jumlah_harga-$detail_penjualan->jumlah_harga;
        $penjualan->update();


        $detail_penjualan->delete();

        // Alert::error('penjualan Sukses Dihapus', 'Hapus');
        return redirect('cart');
    }

    public function konfirmasi()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if(empty($user->location))
        {
            // Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        if(empty($user->phone))
        {
            // Alert::error('Identitasi Harap dilengkapi', 'Error');
            return redirect('profile');
        }

        $penjualan = penjualan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $penjualan_id = $penjualan->id;
        $penjualan->status = 1;
        $penjualan->update();

        $detail_penjualans = DetailPenjualan::where('penjualan_id', $penjualan_id)->get();
        foreach ($detail_penjualans as $detail_penjualan) {
            $produk = produk::where('id', $detail_penjualan->produk_id)->first();
            $produk->stok = $produk->stok-$detail_penjualan->jumlah;
            $produk->update();
        }



        // Alert::success('penjualan Sukses Check Out Silahkan Lanjutkan Proses Pembayaran', 'Success');
        return redirect('history/'.$penjualan_id);

    }
    
}
