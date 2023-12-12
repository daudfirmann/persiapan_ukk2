@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Deskripsi</td>
                                <td>{{ $rsetKategori->deskripsi }}</td>
                            </tr>
                            <tr>
                                <td>Kategori</td>
                                <td>{{ $rsetKategori->kategori }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{ $rsetKategori->ketKategori }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('kategori.index') }}" class="btn btn-md btn-primary mb-3">BACK</a>
                    </div>
               </div>
            </div>
        </div>
    </div>
@endsection
