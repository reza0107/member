<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\DetailPenjualanModel;

class Kasir extends BaseController
{
    protected $barangModel;
    protected $penjualanModel;
    protected $detailModel;

    public function __construct()
    {
        if (!is_superadmin() && !is_kasir()) {

            exit('Akses Ditolak');
        }

        $this->barangModel = new BarangModel();
        $this->penjualanModel = new PenjualanModel();
        $this->detailModel = new DetailPenjualanModel();
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman Kasir
    |--------------------------------------------------------------------------
    */

    public function index()
    {

        $barangModel = new \App\Models\BarangModel();

        $data = [

            'title' => 'Kasir',

            'ctx' => 'kasir',

            'minuman' => $barangModel
                ->where('kategori', 'Minuman')
                ->findAll(),

            'makanan' => $barangModel
                ->where('kategori', 'Makanan')
                ->findAll(),

            'suplemen' => $barangModel
                ->where('kategori', 'Susu Suplemen')
                ->findAll(),

            'lainnya' => $barangModel
                ->where('kategori', 'Lainnya')
                ->findAll(),

            'barang' => $barangModel
                ->orderBy('kategori')
                ->orderBy('nama_barang')
                ->findAll(),

            'cart' => session()->get('cart') ?? []

        ];

        return view('admin/kasir/index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Kategori
    |--------------------------------------------------------------------------
    */

    public function kategori($kategori)
    {
        $barang = $this->barangModel
            ->where('kategori', urldecode($kategori))
            ->findAll();

        return $this->response->setJSON($barang);
    }

    /*
    |--------------------------------------------------------------------------
    | Cari Barang
    |--------------------------------------------------------------------------
    */

    public function cariBarang()
    {
        $keyword = $this->request->getGet('keyword');

        $barang = $this->barangModel
            ->like('nama_barang', $keyword)
            ->orderBy('nama_barang', 'ASC')
            ->findAll();

        return $this->response->setJSON($barang);
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah Keranjang
    |--------------------------------------------------------------------------
    */

    public function tambahKeranjang()
    {
        $idBarang = $this->request->getPost('id_barang');

        $barang = $this->barangModel->find($idBarang);

        if (!$barang) {

            return $this->response->setJSON([
                'status' => false,
                'msg' => 'Barang tidak ditemukan'
            ]);
        }

        if ($barang['stok'] <= 0) {

            return $this->response->setJSON([
                'status' => false,
                'msg' => 'Stok habis'
            ]);
        }

        $cart = session()->get('cart') ?? [];

        if (isset($cart[$idBarang])) {

            if ($cart[$idBarang]['qty'] >= $barang['stok']) {

                return $this->response->setJSON([
                    'status' => false,
                    'msg' => 'Stok tidak mencukupi'
                ]);
            }

            $cart[$idBarang]['qty']++;

            $cart[$idBarang]['subtotal'] =
                $cart[$idBarang]['qty'] *
                $cart[$idBarang]['harga'];
        } else {

            $cart[$idBarang] = [

                'id_barang' => $barang['id_barang'],

                'nama_barang' => $barang['nama_barang'],

                'harga' => $barang['harga_jual'],

                'stok' => $barang['stok'],

                'qty' => 1,

                'subtotal' => $barang['harga_jual']

            ];
        }

        session()->set('cart', $cart);

        $totalQty = 0;

        foreach ($cart as $item) {

            $totalQty += $item['qty'];
        }

        return $this->response->setJSON([

            'status' => true,

            'jumlah' => $totalQty,

            'msg' => 'Barang berhasil ditambahkan'

        ]);
    }
    /*
    |--------------------------------------------------------------------------
    | Tambah Barang ke Keranjang (dari tombol +)
    |--------------------------------------------------------------------------
    */

    public function tambah($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {

            $cart[$id]['qty']++;

            $cart[$id]['subtotal'] =
                $cart[$id]['qty'] * $cart[$id]['harga'];

            session()->set('cart', $cart);
        }

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Tambah Barang ke Keranjang (dari tombol -)
    |--------------------------------------------------------------------------
    */

    public function kurang($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {

            if ($cart[$id]['qty'] > 1) {

                $cart[$id]['qty']--;

                $cart[$id]['subtotal'] =
                    $cart[$id]['qty'] * $cart[$id]['harga'];
            } else {

                unset($cart[$id]);
            }

            session()->set('cart', $cart);
        }

        return redirect()->to('admin/kasir/keranjang');
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Barang dari Keranjang (dari tombol x)
    |--------------------------------------------------------------------------
    */

    public function hapus($id)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$id])) {

            unset($cart[$id]);
        }

        session()->set('cart', $cart);

        return redirect()->back();
    }

    /*
    |--------------------------------------------------------------------------
    | Update Qty
    |--------------------------------------------------------------------------
    */

    public function updateQty()
    {
        $id = $this->request->getPost('id_barang');
        $aksi = $this->request->getPost('aksi');

        $cart = session()->get('cart') ?? [];

        if (!isset($cart[$id])) {
            return $this->response->setJSON([
                'status' => false
            ]);
        }

        if ($aksi == 'plus') {

            $cart[$id]['qty']++;
        } else {

            if ($cart[$id]['qty'] > 1) {

                $cart[$id]['qty']--;
            } else {

                unset($cart[$id]);

                session()->set('cart', $cart);

                return $this->response->setJSON([
                    'status' => true
                ]);
            }
        }

        $cart[$id]['subtotal'] =
            $cart[$id]['qty'] * $cart[$id]['harga'];

        session()->set('cart', $cart);

        return $this->response->setJSON([
            'status' => true
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Keranjang
    |--------------------------------------------------------------------------
    */

    public function hapusKeranjang()
    {
        $idBarang = $this->request->getPost('id_barang');

        $cart = session()->get('cart');

        if (isset($cart[$idBarang])) {

            unset($cart[$idBarang]);
        }

        session()->set('cart', $cart);

        return $this->response->setJSON([

            'status' => true

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Keranjang
    |--------------------------------------------------------------------------
    */

    public function keranjang()
    {
        $data = [

            'title' => 'Keranjang',

            'ctx' => 'kasir',

            'cart' => session()->get('cart') ?? []

        ];

        return view('admin/kasir/keranjang', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Checkout
    |--------------------------------------------------------------------------
    */

    public function checkout()
    {
        $cart = session()->get('cart');

        if (empty($cart)) {

            session()->setFlashdata([
                'msg' => 'Keranjang masih kosong',
                'error' => true
            ]);

            return redirect()->to('/admin/kasir');
        }

        $metode = $this->request->getPost('metode_bayar');

        $bayarCash = (int)$this->request->getPost('bayar_cash');
        $bayarQris = (int)$this->request->getPost('bayar_qris');

        $subtotal = 0;
        $jumlahBarang = 0;

        foreach ($cart as $item) {

            $subtotal += $item['subtotal'];

            $jumlahBarang += $item['qty'];
        }

        /*
    ---------------------------------------
    VALIDASI PEMBAYARAN
    ---------------------------------------
    */

        switch ($metode) {

            case 'Cash':

                $bayarCash = $subtotal;
                $bayarQris = 0;

                break;

            case 'QRIS':

                $bayarCash = 0;
                $bayarQris = $subtotal;

                break;

            case 'Gabungan':

                if (($bayarCash + $bayarQris) != $subtotal) {

                    session()->setFlashdata([
                        'msg' => 'Nominal Cash + QRIS harus sama dengan total belanja',
                        'error' => true
                    ]);

                    return redirect()->back();
                }

                break;

            default:

                session()->setFlashdata([
                    'msg' => 'Metode pembayaran belum dipilih',
                    'error' => true
                ]);

                return redirect()->back();
        }

        /*
    ---------------------------------------
    KODE PENJUALAN
    ---------------------------------------
    */

        $kode =
            'INV' .
            date('YmdHis');

        /*
    ---------------------------------------
    SIMPAN PENJUALAN
    ---------------------------------------
    */

        $this->penjualanModel->insert([

            'kode_penjualan' => $kode,
            'tanggal' => date('Y-m-d H:i:s'),
            'total_barang' => $jumlahBarang,
            'subtotal' => $subtotal,
            'diskon' => 0,
            'total' => $subtotal,
            'metode_bayar' => $metode,
            'bayar_cash' => $bayarCash,
            'bayar_qris' => $bayarQris,
            'kasir' => user()->username

        ]);

        $idPenjualan = $this->penjualanModel->insertID();

        /*
---------------------------------------
DETAIL PENJUALAN
---------------------------------------
*/

        foreach ($cart as $item) {

            $this->detailModel->insert([

                'id_penjualan' => $idPenjualan,
                'id_barang'    => $item['id_barang'],
                'nama_barang'  => $item['nama_barang'],
                'harga'        => $item['harga'],
                'qty'          => $item['qty'],
                'subtotal'     => $item['subtotal']

            ]);

            $barang = $this->barangModel->find($item['id_barang']);

            $this->barangModel->update($item['id_barang'], [

                'stok' => $barang['stok'] - $item['qty']

            ]);
        }

        session()->remove('cart');

        return redirect()->to(
            base_url('admin/kasir/thermal/' . $idPenjualan)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Batalkan Transaksi
    |--------------------------------------------------------------------------
    */

    public function batal()
    {
        // Hapus seluruh isi keranjang
        session()->remove('cart');

        return redirect()->to('admin/kasir')
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $data = [

            'title' => 'Riwayat Penjualan',

            'ctx' => 'kasir',

            'penjualan' => $this->penjualanModel
                ->orderBy('id_penjualan', 'DESC')
                ->findAll()

        ];

        return view('admin/kasir/riwayat', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Transaksi
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $data = [

            'title' => 'Detail Penjualan',

            'ctx' => 'kasir',

            'penjualan' => $this->penjualanModel
                ->find($id),

            'detail' => $this->detailModel
                ->where('id_penjualan', $id)
                ->findAll()

        ];

        return view(
            'admin/kasir/detail',
            $data
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Thermal Print
    |--------------------------------------------------------------------------
    */

    public function thermal($id)
    {

        $penjualan = $this->penjualanModel
            ->find($id);

        $detail = $this->detailModel
            ->select('tb_detail_penjualan.*,tb_barang.nama_barang')
            ->join(
                'tb_barang',
                'tb_barang.id_barang=tb_detail_penjualan.id_barang'
            )
            ->where('id_penjualan', $id)
            ->findAll();

        return view(
            'admin/kasir/thermal',
            [
                'penjualan' => $penjualan,
                'detail' => $detail
            ]
        );
    }
    public function delete($id)
    {
        $db = \Config\Database::connect();

        $db->transStart();

        $detail = $this->detailModel
            ->where('id_penjualan', $id)
            ->findAll();

        foreach ($detail as $d) {

            $barang = $this->barangModel->find($d['id_barang']);

            if ($barang) {

                $this->barangModel->update(
                    $d['id_barang'],
                    [
                        'stok' => $barang['stok'] + $d['qty']
                    ]
                );
            }
        }

        $this->detailModel
            ->where('id_penjualan', $id)
            ->delete();

        $this->penjualanModel
            ->delete($id);

        $db->transComplete();

        return redirect()
            ->to(base_url('admin/kasir/riwayat'))
            ->with('msg', 'Transaksi berhasil dihapus');
    }
}
