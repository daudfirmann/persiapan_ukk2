<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
// use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');

        if ($sort == 'time') {
            $rsetSiswa = Siswa::orderBy('created_at', 'desc')->paginate(10);
        } elseif ($sort == 'id') {
            $rsetSiswa = Siswa::orderBy('id')->paginate(10);
        } else {
            $rsetSiswa = Siswa::latest()->paginate(10);
        }

        return view('vsiswa.index', compact('rsetSiswa'))->with('i', ($request->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vsiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);



        //upload image
        $foto = $request->file('foto');
        $foto->storeAs('foto', $foto->hashName());
        

        //create post
        Siswa::create([
            'nama'     => $request->nama,
            'nis'      => $request->nis,
            'gender'   => $request->gender,
            'kelas'    => $request->kelas,
            'rombel'   => $request->rombel,
            'foto'     => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetSiswa = Siswa::find($id);

        //return $rsetSiswa;

        //return view
        return view('vsiswa.show', compact('rsetSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $akelas = array('blank'=>'Pilih Kelas',
                                    'X'=>'X - Sepuluh',
                                    'XI'=>'XI - Sebelas',
                                    'XII'=>'XII - Dua Belas',
                                    'XIII'=>'XIII - Tiga Belas'
                        );

        $rsetSiswa = Siswa::find($id);
        return view('vsiswa.edit', compact('rsetSiswa','akelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama'    => 'required',
            'nis'     => 'required',
            'gender'  => 'required',
            'kelas'   => 'required|not_in:blank',
            'rombel'  => 'required',
            'foto'    => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $rsetSiswa = Siswa::find($id);

        //check if image is uploaded
        if ($request->hasFile('foto')) {

            //upload new image
            $foto = $request->file('foto');
            $foto->storeAs('foto', $foto->hashName());

            //delete old image
            Storage::delete('foto'.$rsetSiswa->foto);

            //update post with new image
            $rsetSiswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel,
                'foto'    => $foto->hashName()
            ]);

        } else {

            //update post without image
            $rsetSiswa->update([
                'nama'    => $request->nama,
                'nis'     => $request->nis,
                'gender'  => $request->gender,
                'kelas'   => $request->kelas,
                'rombel'  => $request->rombel
            ]);
        }

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetSiswa = Siswa::find($id);
        //delete image
        Storage::delete('foto/'. $rsetSiswa->foto);

        //delete post
        $rsetSiswa->delete();

        //redirect to index
        return redirect()->route('siswa.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
