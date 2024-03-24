<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'image'

    ];
    public function detail_penjualan() 
	{
	     return $this->hasMany('App\Models\DetailPenjualan','produk_id', 'id');
	}

    

    
}
