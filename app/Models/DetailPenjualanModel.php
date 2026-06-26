<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPenjualanModel extends Model
{
    protected $table = 'tb_detail_penjualan';

    protected $primaryKey = 'id_detail';

    protected $allowedFields = [

        'id_penjualan',

        'id_barang',

        'nama_barang',

        'harga',

        'qty',

        'subtotal'

    ];
}
