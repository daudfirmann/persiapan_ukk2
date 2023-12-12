<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        if ($sort == 'time') {
            $rsetBarang = Barang::orderBy('created_at', 'desc')->paginate(10);
        } elseif ($sort == 'id') {
            $rsetBarang = Barang::orderBy('id')->paginate(10);
        } else {
            $rsetBarang = Barang::latest()->paginate(10);
        }

        return view('vbarang.index', compact('rsetBarang'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriOptions = Kategori::pluck('deskripsi', 'id');
        return view('vbarang.create', compact('kategoriOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'merk' => 'nullable|string|max:50',
            'seri' => 'nullable|string|max:50',
            'spesifikasi' => 'required|string',
            'stok' => 'nullable|integer',
            'kategori_id' => 'required|exists:kategori,id'
        ]);
    
        Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok ?? 0,
            'kategori_id' => $request->kategori_id
        ]);
    
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
// BarangController.php

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        $rsetKategori = Kategori::find($rsetBarang->kategori_id);

        return view('vbarang.show', compact('rsetBarang', 'rsetKategori'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = Kategori::pluck('deskripsi', 'id')->toArray();
        $rsetBarang = Barang::find($id);
        $kategoriOptions = Kategori::pluck('deskripsi', 'id');
        
        return view('vbarang.edit', compact('rsetBarang', 'akategori', 'kategoriOptions'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'merk' => 'nullable|string|max:50',
            'seri' => 'nullable|string|max:50',
            'spesifikasi' => 'required|string',
            'stok' => 'nullable|integer',
            'kategori_id' => 'required|exists:kategori,id'
        ]);
    
        $barang = Barang::find($id);
    
        $barang->update([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok ?? 0,
            'kategori_id' => $request->kategori_id
        ]);
    
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $barangExist = DB::table('barang')->where('kategori_id', $id)->exists();
    
    //     if ($barangExist) {
    //         return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus karena masih ada barang terkait!']);
    //     } else {
    //         try {
    //             $rsetKategori = Kategori::findOrFail($id);
    //             $rsetKategori->delete();
    //             return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
    //         } catch (\Exception $e) {
    //             return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
    //         }
    //     }
    // }

    public function destroy(string $id)
    {
        // Cari barang berdasarkan ID
        $rsetBarang = Barang::find($id);
    
        try {
            // Hapus barang
            $rsetBarang->delete();
    
            // Jika berhasil, kembalikan respons sukses
            return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            // Tangani pengecualian jika terjadi kesalahan
            return redirect()->route('barang.index')->with('Gagal', 'Barang gagal dihapus!');
        }
    }
     
}
