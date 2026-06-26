<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table = 'tb_barang';

    protected $primaryKey = 'id_barang';

    protected $allowedFields = [
        'nama_barang',
        'kategori',
        'harga_beli',
        'harga_jual',
        'stok'
    ];

    protected $useTimestamps = false;
}
