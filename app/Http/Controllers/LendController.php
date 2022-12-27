<?php

namespace App\Http\Controllers;

use App\Models\Lend;
use Illuminate\Http\Request;

class LendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $lends = Lend::all()->latest()->get();

            return response()->json($lends, 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $lend = new Lend();
            $lend->id_buku = $request->id_buku;
            $lend->id_anggota = $request->id_anggota;
            $lend->tgl_pinjam = $request->date('tgl_pinjam');
            $lend->tgl_kembali = $request->date('tgl_kembali');
            $lend->tgl_dikembalikan = $request->date('tgl_dikembalikan');
            $lend->status_peminjaman = $request->status_peminjaman;

            $lend->save();
            return response()->json(['success' => 'added lend'], 201);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $lend = Lend::find($id)->get();
            return response()->json($lend, 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                404
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        try {
            $lend = Lend::find($id);
            $lend->id_buku = $request->id_buku;
            $lend->id_anggota = $request->id_anggota;
            $lend->tgl_pinjam = $request->date('tgl_pinjam');
            $lend->tgl_kembali = $request->date('tgl_kembali');
            $lend->tgl_dikembalikan = $request->date('tgl_dikembalikan');
            $lend->status_peminjaman = $request->status_peminjaman;

            $lend->save();
            return response()->json(['success' => 'updated lend'], 201);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $lend = Lend::find($id);
            $lend->delete();

            return response()->json(['success' => 'deleted lend'], 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                404
            );
        }
    }
}
