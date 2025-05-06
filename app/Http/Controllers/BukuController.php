<?php

namespace App\Http\Controllers;
use App\Models\BukuModel;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $listBuku = BukuModel::all();
        //$listBuku = BukuModel::where('judul_buku','like','%'.$request->item.'%')->get();
        $data = [
            'data' => $listBuku,
            'message' => 'Daftar buku berhasil diambil',
            'statusCode' => 200
        ];
        return response()->json($data, $data['statusCode']);
        //return response()->json($data, 200);
    }
    public function cari(Request $request){
        if($request->filled('item')){
            $listBuku = BukuModel::where('judul_buku','like','%'.$request->item.'%')->get();
            $data = [
                'data' => $listBuku,
                'message' => 'Daftar buku berhasil diambil',
                'statusCode' => 200
            ];
            return response()->json($data, $data['statusCode']);
        } 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        /**
         * Kolom buku
         * 1. id_buku
         * 2. judul_buku
         * 3. pengarang
         * 4. Penerbit
         *
         * @param string $id
         * @return void
         */
        if (empty($request->judul_buku) || empty($request->pengarang) || empty($request->penerbit)):
            $pesan = [
                'status'    => false,
                'message'   => 'Data tidak lengkap/kosong, silahkan dilengkapi'
            ];
            $status = 403; //Forbidden
        else:
            $data = [
                'judul_buku'    => $request->judul_buku,
                'pengarang'     => $request->pengarang,
                'penerbit'      => $request->penerbit
            ];
            if (BukuModel::create($data)):
                $pesan = [
                    'status'    => true,
                    'message'   => 'Data berhasil ditambahkan'
                ];
                $status = 201;
            else:
                $pesan = [
                    'status'    => false,
                    'message'   => 'Data tidak lengkap/kosong, silahkan dilengkapi'
                ];
                $status = 400; //Forbidden
            endif;
        endif;
        return response()->json($pesan, $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $data = BukuModel::where('id_buku', '=', $id)->get();
        return response()->json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        if (empty($request->judul_buku) || empty($request->pengarang) || empty($request->penerbit)):
            $pesan  = [
                'status'    => false,
                'message'   => 'Update data gagal, periksa lagi data yang dikirim'
            ];
            $status = 403;
            
        else:
            $data = [
                'judul_buku'    => $request->judul_buku,
                'pengarang'     => $request->pengarang,
                'penerbit'      => $request->penerbit
            ];
            $update = BukuModel::where('id_buku','=',$id)->update($data);
            if ($update):
                $pesan = [
                    'status'    => true,
                    'message'   => 'Data berhasil diperbarui'
                ];
                $status = 201;
            else:
                $pesan = [
                    'status'    => false,
                    'message'   => 'Data gagal diperbarui'
                ];
                $status = 400; //Forbidden
            endif;
        endif;
        return response()->json($pesan,$status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $aksiHapus = BukuModel::where('id_buku', '=', $id)->delete();
        if ($aksiHapus):
            $pesan = [
                'status'    => true,
                'message'   => 'Data berhasil dihapus'
            ];
            $status = 200; //Ok
        else:
            $pesan = [
                'status'    => false,
                'message'   => 'Data gagal dihapus'
            ];
            $status = 401; //Forbidden
        endif;
        return response()->json($pesan, $status);
    }
}
