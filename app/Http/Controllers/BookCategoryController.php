<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Http\Requests\BookCategoryRequest;
use Illuminate\Support\Facades\Validator;

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
            $bookCategories = BookCategory::latest()->get();

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
     * @param  \App\Http\Requests\BookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCategoryRequest $request)
    {
        try {
            $validator = Validator::make($request->all(), BookCategoryRequest::rules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $bookCategory = new BookCategory();
            $bookCategory->category = $request->category_name;
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
            $bookCategory = BookCategory::find($id);
            if (!$bookCategory) {
                return response()->json(
                    ['error' => 'data not found'],
                    404
                );
            } else {
                return response()->json($bookCategory, 200);
            }
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th],
                400
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BookCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(BookCategoryRequest $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), BookCategoryRequest::rules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $bookCategory = BookCategory::find($id);
            $bookCategory->category = $request->category_name;
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
    public function destroy($id)
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
