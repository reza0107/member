<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table = 'tb_penjualan';

    protected $primaryKey = 'id_penjualan';

    protected $allowedFields = [

        'kode_penjualan',
        'tanggal',
        'total_barang',
        'subtotal',
        'diskon',
        'total',
        'metode_bayar',
        'bayar_cash',
        'bayar_qris',
        'kasir'

    ];
}
