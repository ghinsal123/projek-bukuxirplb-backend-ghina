<?php

namespace App\Http\Controllers; // Namespace controller Laravel

use App\Models\BukuModel; // Import model Buku
use Illuminate\Http\Request; // Import class Request untuk ambil data dari HTTP request


class BukuController extends Controller // Kelas controller untuk handle request terkait data buku
{
    // Properti class (optional), bisa dipakai untuk simpan data sementara    
    protected $id,$judul,$pengarang,$tahun_terbit,$buku;

    /**
     * Menampilkan seluruh data buku (READ ALL)
     */
    public function index(Request $request)
    {
        //
        //if($request->ajax()):

            // Mengambil semua data dari tabel_buku menggunakan Model
            $this->buku = BukuModel::all();

            
            // Mengembalikan response dalam bentuk JSON
            return response()->json(
                [
                    'buku' => $this->buku
                ],200
            );
        //endif;    
        //echo "API BUKU KU";
    }

    /**
     * Menyimpan data buku baru ke database (CREATE)
     */    
    public function store(Request $request)
    {
        // Validasi input: jika salah satu input kosong
        if(empty($request->judul_buku) || empty($request->pengarang) || empty($request->tahun_terbit)):
            $pesan = [
                [
                    'status' => false,
                    'message' => 'Data tidak boleh kosong' // Pesan error
                ],
            ];
            $status = 403; // Forbidden
    else:
        // Menyimpan data ke array
        $data = [
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'tahun_terbit' => $request->tahun_terbit,
        ];

        // Simpan data ke database
        BukuModel::create($data);

         // Pesan sukses
        $pesan = [
            [
                'status' => true,
                'message' => 'Data berhasil ditambahkan'
            ],
        ];
        $status = 200; // OK
    endif;

    // Mengembalikan response JSON
    return response()
        ->json($pesan,$status);
    }

    /**
     * Menampilkan satu data buku berdasarkan ID (READ by ID)
     */    
    public function show(string $id)
    {
         // Ambil data dari tabel_buku berdasarkan id_buku
        $data = BukuModel::where('id_buku','=',$id)->get();

        // Kembalikan response JSON
        return response()->json($data,200);
    }

    /**
     * Memperbarui data buku berdasarkan ID (UPDATE)
     */    
    public function update(Request $request, string $id)
    {
        // Validasi input
        if (empty($request->judul_buku) || empty($request->pengarang) || empty($request->tahun_terbit)):
            $pesan = [
                'status'    => false,
                'message'   =>'Update data gagal, periksa lagi data yang dikirim'
            ];
            $status = 430; // Status custom
        else:
            // Data yang akan diupdate
            $data = [
                'judul_buku'    => $request->judul_buku,
                'pengarang'     => $request->pengarang,
                'tahun_terbit'  => $request->tahun_terbit,
            ];
            // Jalankan query update
            $update = BukuModel::where('id_buku','=',$id)->update($data);

             // Cek hasil update
            if ($update):
                $pesan = [
                    'status'    => true,
                    'message'   => 'Data berhasil diperbaharui'
                ];
                $status = 201;
            else:
                $pesan = [
                    'status'    => false,
                    'message'   => 'Data gagal diperbaharui'
                ];
                $status = 400; //forbidden
            endif;
        endif;

        // Kembalikan response JSON
        return response()->json($pesan,$status);
    }

    /**
     * Menghapus data buku berdasarkan ID (DELETE)
     */    
    public function destroy(string $id)
    {
        // Hapus data dari database
        $aksiHapus = BukuModel::where('id_buku','=',$id)->delete();

         // Cek hasil penghapusan
        if ($aksiHapus):
             $pesan = [
                'status'    => true,
                'message'   => 'Data berhasil dihapus'
             ];
             $status = 200; // OK
        else:
            $pesan = [
                'status'    => false,
                'message'   => 'Data gagal dihapus'
             ];
             $status = 401; // Unauthorized
        endif;

        // Kembalikan response JSON
        return response()->json($pesan,$status);
        
    }
}
