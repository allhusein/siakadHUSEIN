@extends('mahasiswa.layout')
@section('content')
<div class="container">
    <div class="justify-content-center align-items-center">
        <div class="d-flex justify-content-center mt-1">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
        </div>
        <div class="d-flex justify-content-center my-5">
            <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
        </div>
        <a class="btn btn-success float-right" href="{{ route('cetak', $mahasiswa->nim) }}"> Cetak KHS</a>
        <div class="row mb-2">
            <ul class="" style="list-style-type: none;">

                <li class=""><b>Nama: </b>{{$mahasiswa->nama}}</li>
                <li class=""><b>Nim: </b>{{$mahasiswa->nim}}</li>
                <li class=""><b>Kelas: </b>{{$mahasiswa->kelas->nama_kelas}}</li>
            </ul>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Mata Kuliah</th>
                    <th scope="col">SKS</th>
                    <th scope="col">Semester</th>
                    <th scope="col">Nilai Angka</th>
                    <th scope="col">Nilai Huruf</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matakuliah as $ls)
                <tr scope="row">
                    <td>
                        {{$ls->matakuliah->nama_matkul}}
                    </td>
                    <td>
                        {{$ls->matakuliah->sks}}
                    </td>
                    <td>
                        {{$ls->matakuliah->semester}}
                    </td>
                    <td>
                        {{$ls ->nilai_angka}}
                    </td>
                    <td>
                        {{$ls ->nilai_huruf}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-success mt3" href="{{ route('mahasiswa.index') }}">Kembali</a>
    </div>
</div>
@endsection