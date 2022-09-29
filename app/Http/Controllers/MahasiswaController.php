<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;
use App\Models\MataKuliah;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            $paginate = Mahasiswa::where('nim', 'like', '%' . request('search') . '%')
                ->orwhere('nim', 'like', '%' . request('search') . '%')
                ->orwhere('nama', 'like', '%' . request('search') . '%')
                ->orwhere('email', 'like', '%' . request('search') . '%')
                ->orwhere('alamat', 'like', '%' . request('search') . '%')
                ->orwhere('tanggal_lahir', 'like', '%' . request('search') . '%')
                ->orwhere('jenis_kelamin', 'like', '%' . request('search') . '%')
                ->orwhere('kelas_id', 'like', '%' . request('search') . '%')
                ->orwhere('jurusan', 'like', '%' . request('search') . '%')->paginate(3);
            return view('mahasiswa.index', ['paginate' => $paginate]);
        } else {
            //fungsi eloquent menampilkan data menggunakan pagination
            // yang semula $mahasiswa = Mahasiswa::all();  diubah menjadi with yang menyatakan relasi
            $mahasiswa = Mahasiswa::with('kelas')->get();
            $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
            return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('foto')) {
            $image_name = $request->file('foto')->store('fotos', 'public');
        } else {
            $image_name = 'default.jpg';

        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
            'Jenis_Kelamin' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->foto = $image_name;
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data dengan relasi belongsTo
       $mahasiswa->kelas()->associate($kelas);
       $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data berdasarkan Nim Mahasiswa
        //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();

        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
            return view('mahasiswa.edit', compact('mahasiswa','kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi data
            $request->validate([
                'Nim' => 'required',
                'Nama' => 'required',
                'Email' => 'required',
                'Alamat' => 'required',
                'Tanggal_Lahir' => 'required',
                'Jenis_Kelamin' => 'required',
                'Kelas' => 'required',
                'Jurusan' => 'required',
            ]);

            $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
            if ($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))) {
                Storage::delete('public/' . $mahasiswa->foto);  
            }
            $image_name = $request->file('foto')->store('fotos', 'public');
            $mahasiswa->nim = $request->get('Nim');
            $mahasiswa->nama = $request->get('Nama');
            $mahasiswa->email = $request->get('Email');
            $mahasiswa->alamat = $request->get('Alamat');
            $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
            $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
            $mahasiswa->kelas_id = $request->get('Kelas');
            $mahasiswa->jurusan = $request->get('Jurusan');
            $mahasiswa->foto = $image_name;
            $mahasiswa->save();

            $kelas = new Kelas;
            $kelas->id = $request->get('Kelas');

            //fungsi eloquent untuk mengupdate data dengan relasi belongsTo  
            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //jika data berhasil diupdate, akan kembali ke halaman utama
            return redirect()->route('mahasiswa.index')
                ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $nim)->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($nim)
    {
        $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
        $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs -> id_mahasiswa))->get();
        return view('mahasiswa.nilai', ['mahasiswa' => $mhs,'matakuliah'=>$matkul]);
    }

    public function cetak($nim){
        $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
        $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs -> id_mahasiswa))->get();
        // $matkul = Mahasiswa_Matakuliah::where('matakuliah_id', ($mhs -> id_mahasiswa))->first();
        $pdf = PDF::loadview('mahasiswa.cetak', ['mahasiswa' => $mhs,'matakuliah'=>$matkul]);
        return $pdf->stream();
    }
}