<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
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
            $member->password = Hash::make("password1234");
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
     * @return \Illuminate\Http\JsonResponse
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), UpdateMemberRequest::rules());
            if ($validator->fails()) {
                return response()->json([
                    'error' => $validator->errors()->all()
                ], 400);
            }

            $member = Member::find($id);
            $member->name = $request->name;
            $member->email = $request->email;
            // $member->password = Hash::make("Password");
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
     * @return \Illuminate\Http\JsonResponse
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
            return response()->json(['message' => 'Invalid email or password2'], 401);
        }

        if (!$token = auth()->guard('apimembers')->attempt($credentials)) {
            // var_dump($token);
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function member()
    {
        return response()->json([
            'data' => auth()->guard('apimembers')->user()
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
