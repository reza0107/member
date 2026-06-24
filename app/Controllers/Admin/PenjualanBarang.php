<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenjualanBarangModel;

class PenjualanBarang extends BaseController
{
    protected $penjualanModel;

    public function __construct()
    {
        $this->penjualanModel =
            new PenjualanBarangModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Penjualan Barang',
            'ctx' => 'penjualan-barang',
            'barang' => $this->penjualanModel
                ->orderBy('id_penjualan', 'DESC')
                ->findAll()
        ];

        return view(
            'admin/penjualan-barang/index',
            $data
        );
    }

    public function create()
    {
        $qty = $this->request->getPost('qty');
        $harga = $this->request->getPost('harga_satuan');

        $this->penjualanModel->insert([
            'nama_barang' =>
            $this->request->getPost('nama_barang'),

            'qty' => $qty,

            'harga_satuan' => $harga,

            'total_harga' => $qty * $harga,

            'metode_bayar' =>
            $this->request->getPost('metode_bayar'),

            'bayar_cash' =>
            $this->request->getPost('bayar_cash'),

            'bayar_qris' =>
            $this->request->getPost('bayar_qris'),

            'tanggal_penjualan' => date('Y-m-d')
        ]);

        return redirect()->to(
            '/admin/penjualan-barang'
        );
    }
}
