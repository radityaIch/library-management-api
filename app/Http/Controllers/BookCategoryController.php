<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Http\Requests\StoreBookCategoryRequest;
use App\Http\Requests\UpdateBookCategoryRequest;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $bookCategories = BookCategory::all()->latest()->get();

            return response()->json($bookCategories, 200);
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
     * @param  \App\Http\Requests\StoreBookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookCategoryRequest $request)
    {
        try {
            $bookCategory = new BookCategory();
            $bookCategory->category_name = $request->category_name;
            $bookCategory->save();

            return response()->json(['success' => 'added category'], 201);
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
            $bookCategory = BookCategory::find($id)->get();
            return response()->json($bookCategory, 200);
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
     * @param  \App\Http\Requests\UpdateBookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookCategoryRequest $request, $id)
    {
        try {
            $bookCategory = BookCategory::find($id);
            $bookCategory->category_name = $request->category_name;
            $bookCategory->save();

            return response()->json(['success' => 'updated category'], 200);
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
    public function destroy(BookCategory $id)
    {
        try {
            $bookCategory = BookCategory::find($id);
            $bookCategory->delete();

            return response()->json(['success' => 'deleted category'], 200);
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                404
            );
        }
    }
}
