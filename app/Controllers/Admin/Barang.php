<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class Barang extends BaseController
{
    protected $barangModel;

    public function __construct()
    {
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Master Barang',
            'ctx'     => 'barang',
            'barang'  => $this->barangModel
                ->orderBy('nama_barang', 'ASC')
                ->findAll()
        ];

        return view('admin/barang/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Barang',
            'ctx'   => 'barang'
        ];

        return view('admin/barang/create', $data);
    }

    public function store()
    {
        $this->barangModel->insert([

            'nama_barang' => $this->request->getPost('nama_barang'),

            'kategori'    => $this->request->getPost('kategori'),

            'harga_beli'  => $this->request->getPost('harga_beli'),

            'harga_jual'  => $this->request->getPost('harga_jual'),

            'stok'        => $this->request->getPost('stok'),

            'created_at'  => date('Y-m-d H:i:s')

        ]);

        session()->setFlashdata([
            'msg'   => 'Barang berhasil ditambahkan',
            'error' => false
        ]);

        return redirect()->to('/admin/barang');
    }

    public function edit($id)
    {
        $data = [

            'title' => 'Edit Barang',

            'ctx'   => 'barang',

            'barang' => $this->barangModel->find($id)

        ];

        return view('admin/barang/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id_barang');

        $this->barangModel->update($id, [

            'nama_barang' => $this->request->getPost('nama_barang'),

            'kategori' => $this->request->getPost('kategori'),

            'harga_beli' => $this->request->getPost('harga_beli'),

            'harga_jual' => $this->request->getPost('harga_jual'),

            'stok' => $this->request->getPost('stok')

        ]);

        session()->setFlashdata([
            'msg' => 'Barang berhasil diubah',
            'error' => false
        ]);

        return redirect()->to('/admin/barang');
    }

    public function delete($id)
    {
        $this->barangModel->delete($id);

        session()->setFlashdata([
            'msg' => 'Barang berhasil dihapus',
            'error' => false
        ]);

        return redirect()->to('/admin/barang');
    }
}
