@extends('dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>{{ $rsetSiswa->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>{{ $rsetSiswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $rsetSiswa->gender }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>{{ $rsetSiswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Rombel</td>
                                <td>{{ $rsetSiswa->rombel }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('siswa.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                    </div>
               </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('storage/foto/'.$rsetSiswa->foto) }}" class="w-100 rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection