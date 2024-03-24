<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'pesanan_id',
        'jumlah',
        'Jumlah_harga'

    ];

    public function produk()
	{
	      return $this->belongsTo('App\Models\produk','produk_id', 'id');
	}

	public function pesanan()
	{
	      return $this->belongsTo('App\Models\Pesanan','pesanan_id', 'id');
	}
}
