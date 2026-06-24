<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanBarangModel extends Model
{
    protected $table = 'tb_penjualan_barang';

    protected $primaryKey = 'id_penjualan';

    protected $allowedFields = [
        'nama_barang',
        'qty',
        'harga_satuan',
        'total_harga',
        'metode_bayar',
        'bayar_cash',
        'bayar_qris',
        'tanggal_penjualan'
    ];
}
