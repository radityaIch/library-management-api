<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $books = Book::latest()->get();

            return response()->json($books, 200);
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
            $validator = Validator::make($request->all(), BookRequest::rules());

            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $book = new Book();
            $book->id_kategori = $request->id_kategori;
            $book->judul = $request->judul;
            $book->deskripsi = $request->deskripsi;
            $book->author = $request->author;

            $image = $request->file('cover_image');
            $book->cover_image = uniqid() . '-' . $image->getFilename() . '.' . $image->getClientOriginalExtension();

            $book->qty = $request->qty;

            $image->storeAs('public/images/books/cover', $book->cover_image);

            $book->save();

            return response()->json(['success' => 'added book'], 201);
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
            $book = Book::find($id);
            return response()->json($book, 200);
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
            $book = Book::find($id);
            $book->id_kategori = $request->id_kategori;
            $book->judul = $request->judul;
            $book->deskripsi = $request->deskripsi;
            $book->author = $request->author;

            $image = $request->file('cover_image');

            if (Storage::exists('public/images/books/cover/' . $book->cover_image)) {
                Storage::delete('public/images/books/cover/' . $book->cover_image);
            }

            $book->cover_image = uniqid() . '-' . $image->getClientOriginalName();
            $image->storeAs('public/images/books/cover', $book->cover_image);

            $book->qty = $request->qty;

            $book->save();

            return response()->json(['success' => 'updated book'], 201);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()],
                500
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
            $book = Book::find($id);
            Storage::delete('public/images/books/cover/' . $book->cover_image);
            $book->delete();

            return response()->json(['success' => 'deleted book'], 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                404
            );
        }
    }
}
