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
        try {
            $members = Member::latest()->get();

            return response()->json($members, 200);
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
     * @param  \App\Http\Requests\StoreMemberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        try {
            $validator = Validator::make($request->all(), StoreMemberRequest::rules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $member = new Member();
            $member->name = $request->name;
            $member->email = $request->email;
            $member->password = $request->password;
            $member->phone = $request->phone;
            $member->address = $request->address;

            $member->save();

            return response()->json(
                ['success' => 'added member'],
                201
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => 'failed to add member : ' . $th],
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
            $member = Member::find($id);
            return response()->json($member, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'data not found : ' . $th
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
            $validator = Validator::make($request->all(), StoreMemberRequest::rules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $member = Member::find($id);
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
                'error' => 'can\'t update member : ' . $th
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
                'error' => 'data not found : ' . $th
            ], 404);
        }
    }


    public function login()
    {
        $credentials = request(['email', 'password']);

        $member = Member::where('email', $credentials['email'])->first();

        if (!$member) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        if ($member->email_verified_at == null) {
            return response()->json(['message' => 'Email not verified'], 401);
        }

        if ($member->verified == null) {
            return response()->json(['message' => 'Not verified by admin'], 401);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function member()
    {
        return response()->json([
            'data' => auth()->user()
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'member logged out successfully']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 720
        ]);
    }
}
