<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barangkeluar;
use App\Models\Barang;

class BarangkeluarController extends Controller
{
    public function index()
    {
        // Mengambil data dari tabel 'barangkeluar' menggunakan Eloquent ORM dengan relasi ke 'barang'
        $barangkeluar = Barangkeluar::with('barang')->latest()->paginate(10);

        return view('vbarangkeluar.index', compact('barangkeluar'));
    }

    public function create()
    {
        $merkBarang = Barang::pluck('merk', 'id');
        // Menampilkan form untuk membuat data barang keluar
        return view('vbarangkeluar.create', compact('merkBarang'));
    }

    public function store(Request $request)
    {
        // Validasi data dari request jika diperlukan
        $validatedData = $request->validate([
            'tgl_keluar' => 'required',
            'qty_keluar' => 'required|numeric|min:0',
            'barang_id' => 'required',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Simpan data barang keluar baru ke database
        $barangKeluar = new Barangkeluar();
        $barangKeluar->tgl_keluar = $request->tgl_keluar;
        $barangKeluar->qty_keluar = $request->qty_keluar;
        $barangKeluar->barang_id = $request->barang_id;
        // Tambahkan kolom lainnya yang perlu diisi
        $barangKeluar->save();

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil ditambahkan');
    }

    public function show($id)
    {
        // Mengambil data barang keluar berdasarkan ID
        $barangkeluar = Barangkeluar::findOrFail($id);
    
        return view('vbarangkeluar.show', compact('barangkeluar'));
    }

    public function edit($id)
    {
        // Mengambil data barang keluar untuk diedit berdasarkan ID
        $barangkeluar = Barangkeluar::findOrFail($id);
        $merkBarang = Barang::pluck('merk', 'id');
    
        return view('vbarangkeluar.edit', compact('barangkeluar', 'merkBarang'));
    }
    
    public function update(Request $request, $id)
    {
        // Validasi data dari request jika diperlukan
        $validatedData = $request->validate([
            'tgl_keluar' => 'required',
            'qty_keluar' => 'required|numeric|min:0',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);
    
        // Temukan data barang keluar yang akan diupdate
        $barangKeluar = BarangKeluar::findOrFail($id);
    
        // Hitung perbedaan antara jumlah keluar yang baru dan yang sebelumnya
        $difference = $request->qty_keluar - $barangKeluar->qty_keluar;
    
        // Simpan perubahan data barang keluar ke database
        $barangKeluar->tgl_keluar = $request->tgl_keluar;
        $barangKeluar->qty_keluar = $request->qty_keluar;
        $barangKeluar->save();
    
        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil diperbarui');
    }
    
    
    public function destroy($id)
    {
        // Menghapus data barang keluar berdasarkan ID
        $barangkeluar = Barangkeluar::findOrFail($id);
        $barangkeluar->delete();
    
        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil dihapus');
    }
}
