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
        $bookCategories = BookCategory::all()->latest()->get();

        return response()->json($bookCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookCategoryRequest $request)
    {
        $bookCategory = new BookCategory();
        $bookCategory->category_name = $request->category_name;
        $bookCategory->save();

        return response()->json(['success' => 'added category'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bookCategory = BookCategory::find($id)->get();

        return response()->json($bookCategory, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookCategoryRequest $request, $id)
    {
        $bookCategory = BookCategory::find($id);
        $bookCategory->category_name = $request->category_name;
        $bookCategory->save();

        return response()->json(['success' => 'updated category'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookCategory $id)
    {
        $bookCategory = BookCategory::find($id);
        $bookCategory->delete();

        return response()->json(['success' => 'deleted category'], 200);
    }
}
