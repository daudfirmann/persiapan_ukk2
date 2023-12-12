@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('siswa.create') }}" class="btn btn-md btn-success">TAMBAH SISWA</a>
                    </div>
                </div>

                <div class="sort-buttons text-right mt-2 mb-2">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-filter"></i> Sort By
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sortDropdown">
                            <a class="dropdown-item" href="{{ route('siswa.index', ['sort' => 'time']) }}">Date Created</a>
                            <a class="dropdown-item" href="{{ route('siswa.index', ['sort' => 'id']) }}">ID</a>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>NAMA</th>
                            <th>NIS</th>
                            <th>GENDER</th>
                            <th>KELAS</th>
                            <th>ROMBEL</th>
                            <th>FOTO</th>
                            <th style="width: 15%">AKSI</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetSiswa as $rowsiswa)
                            <tr>
                                <td>{{ $rowsiswa->id  }}</td>
                                <td>{{ $rowsiswa->nama  }}</td>
                                <td>{{ $rowsiswa->nis  }}</td>
                                <td>{{ $rowsiswa->gender  }}</td>
                                <td>{{ $rowsiswa->kelas  }}</td>
                                <td>{{ $rowsiswa->rombel  }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/foto/'.$rowsiswa->foto) }}" class="rounded" style="width: 150px">
                                </td>
                                <td class="text-center"> 
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('siswa.destroy', $rowsiswa->id) }}" method="POST">
                                        <a href="{{ route('siswa.show', $rowsiswa->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('siswa.edit', $rowsiswa->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                                
                            </tr>
                        @empty
                            <div class="alert">
                                Data Siswa belum tersedia
                            </div>
                        @endforelse
                    </tbody>
                    
                </table>
                <div class="pagination">
                    {{ $rsetSiswa->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection