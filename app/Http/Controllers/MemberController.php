<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::latest()->get();
        return response()->json($members, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        try {
            $member = new Member();
            $member->name = $request->name;
            $member->email = $request->email;
            $member->password = $request->password;
            $member->phone = $request->phone;
            $member->address = $request->address;

            $member->save();

            return response()->json(
                ['success' => 'added member'],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => 'failed to add member'],
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
            $member = Member::find($id)->get();
            return response()->json($member, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'data not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        try {
            $member = Member::find($id)->get();
            $member->name = $request->name;
            $member->email = $request->email;
            $member->password = $request->password;
            $member->phone = $request->phone;
            $member->address = $request->address;

            $member->save();

            return response()->json(
                ['success' => 'added member'],
                200
            );
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'can\'t update member'
            ], 400);
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
            $member = Member::find($id);
            $member->delete();
            return response()->json([
                'success' => 'delete data'
            ], 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'data not found'
            ], 404);
        }
    }
}
