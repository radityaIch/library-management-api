<?php

namespace App\Http\Controllers;

use App\Models\Lend;
use Illuminate\Http\Request;

class LendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $lends = Lend::With('books')->with('members')->latest()->get();

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $check = Lend::where([['id_buku', $request->id_buku], ['status_peminjaman', 'sedang dipinjam']])->get();
            if ($check) {
                return response()->json(['Error' => 'Can\'t lend the same book'], 401);
            }

            $lend = new Lend();
            $lend->id_buku = $request->id_buku;
            $lend->id_anggota = $request->id_anggota;
            $lend->tgl_pinjam = $request->date('tgl_pinjam');
            $lend->tgl_kembali = $request->date('tgl_kembali');
            $lend->status_peminjaman = 'menunggu konfirmasi';

            // $lend->save();
            return response()->json(['success' => 'added lend'], 201);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    public function storeAdmin(Request $request)
    {
        try {
            $check = Lend::where([['id_buku', $request->id_buku], ['status_peminjaman', 'sedang dipinjam']])->count();
            if ($check > 0) {
                return response()->json(['Error' => 'Can\'t lend the same book'], 400);
            }

            $lend = new Lend();
            $lend->id_buku = $request->id_buku;
            $lend->id_anggota = $request->id_anggota;
            $lend->tgl_pinjam = $request->date('tgl_pinjam');
            $lend->tgl_kembali = $request->date('tgl_kembali');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $lend = Lend::find($id);
            return response()->json($lend, 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                404
            );
        }
    }

    /**
     * Summary of showByMember
     * @param Request $request -> get request from middleware
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByMember(Request $request)
    {
        try {
            $id = $request->id;
            $lend = Lend::latest()->where('id_anggota', $id)->get();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $lend = Lend::find($id);
            // $lend->id_buku = $request->id_buku;
            // $lend->id_anggota = $request->id_anggota;
            // $lend->tgl_pinjam = $request->date('tgl_pinjam');
            // $lend->tgl_kembali = $request->date('tgl_kembali');
            $lend->status_peminjaman = $request->status_peminjaman;
            $lend->tgl_dikembalikan = $request->date('tgl_dikembalikan');
            if ($lend->tgl_dikembalikan != NULL) {
                if ($lend->status_peminjaman != "hilang") {
                    $diff = strtotime($lend->tgl_kembali) - strtotime($lend->tgl_dikembalikan);
                    if (round($diff / 86400) < 0) {
                        $lend->tgl_dikembalikan = strftime('%Y-%m-%d', strtotime($request->date('tgl_dikembalikan')));
                        $lend->status_peminjaman = "terlambat";
                    } else {
                        $lend->status_peminjaman = "sudah dikembalikan";
                        // echo $diff;
                    }
                }
            }
            $lend->save();
            return response()->json(['success' => 'updated lend status'], 201);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    public function updateAdmin(Request $request, $id)
    {
        try {
            $lend = Lend::find($id);
            $lend->id_buku = $request->id_buku;
            $lend->id_anggota = $request->id_anggota;
            $lend->tgl_pinjam = $request->date('tgl_pinjam');
            $lend->tgl_kembali = $request->date('tgl_kembali');
            $lend->status_peminjaman = $request->status_peminjaman;
            $lend->tgl_dikembalikan = $request->date('tgl_dikembalikan');
            if ($lend->tgl_dikembalikan) {
                if ($lend->status_peminjaman != 'hilang') {
                    $diff = strtotime($lend->tgl_kembali) - strtotime($lend->tgl_dikembalikan);
                    if (round($diff / 86400) < 0) {
                        $lend->status_peminjaman = 'terlambat';
                    } else {
                        $lend->status_peminjaman = 'sudah dikembalikan';
                    }
                }
            }

            $lend->save();
            return response()->json(['success' => 'updated lend status'], 201);
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
     * @return \Illuminate\Http\JsonResponse
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
