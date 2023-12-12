@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('barang.create') }}" class="btn btn-md btn-success">TAMBAH BARANG</a>
                        @if(session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('Gagal'))
                            <div class="alert alert-danger mt-3">
                                {{ session('Gagal') }}
                            </div>
                        @endif                    
                    </div>
                </div>

                <div class="sort-buttons text-right mt-3 mb-3">
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle btn-sm" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter"></i> Sort By
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sortDropdown">
                            <a class="dropdown-item" href="{{ route('barang.index', ['sort' => 'time']) }}">Date Created</a>
                            <a class="dropdown-item" href="{{ route('barang.index', ['sort' => 'id']) }}">ID</a>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>MERK</th>
                            <th>SERI</th>
                            <th>SPESIFIKASI</th>
                            <th>STOK</th>
                            <th>KATEGORI</th>
                            <th style="width: 15%">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarang as $barang)
                            <tr>
                                <td>{{ $barang->id }}</td>
                                <td>{{ $barang->merk }}</td>
                                <td>{{ $barang->seri }}</td>
                                <td>{{ $barang->spesifikasi }}</td>
                                <td>{{ $barang->stok }}</td>
                                <td>
                                    @if ($barang->kategori)
                                        {{ $barang->kategori->deskripsi }}
                                    @else
                                        Kategori tidak ditemukan
                                    @endif
                                </td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $barang->id) }}" method="POST">
                                        <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data Barang belum tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $rsetBarang->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
