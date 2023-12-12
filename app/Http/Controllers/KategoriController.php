<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\Barang;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rsetKategori = DB::select('CALL getKategoriAll');
        
        $kategori = DB::table('kategori')
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategori(kategori.kategori) as ketKategori'))
            ->latest()
            ->paginate(10);
            
        return view('vkategori.index', compact('rsetKategori', 'kategori'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aKategori = [
            'blank' => 'Pilih Kategori',
            'M' => 'Barang Modal',
            'A' => 'Alat',
            'BHP' => 'Bahan Habis Pakai',
            'BTHP' => 'Bahan Tidak Habis Pakai'
        ];

        return view('vkategori.create', compact('aKategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'deskripsi' => 'required',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);

        // Membuat data baru
        Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data kategori berdasarkan ID
        $rsetKategori = DB::table('kategori')
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategori(kategori.kategori) as ketKategori'))
            ->where('kategori.id', $id)
            ->first();
    
        return view('vkategori.show', compact('rsetKategori'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mendapatkan data kategori berdasarkan ID untuk diedit
        $rsetKategori = Kategori::findOrFail($id);

        return view('vkategori.edit', compact('rsetKategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'deskripsi' => 'required',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);

        // Mengupdate data kategori berdasarkan ID
        $rsetKategori = Kategori::findOrFail($id);
        $rsetKategori->deskripsi = $request->deskripsi;
        $rsetKategori->kategori = $request->kategori;
        $rsetKategori->save();

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
}
