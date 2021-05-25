<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $users = User::with(['vaccination'])->get();
        return $users;
    }

    public function findByID(int $id) : User {
        $user = User::where('id', $id)->with(['vaccination'])->first();
        return $user;
    }

    public function delete(int $id) : JsonResponse
    {
        $user = User::where('id', $id)->first();
        if ($user != null) {
            $user->delete();
        }
        else
            throw new \Exception("User couldn't be deleted - it does not exist");
        return response()->json('User (' . $id . ') successfully deleted', 200);
    }

    public function show($user){
        $user = User::find($user);
        return view('users.show',compact('user'));
    }

    public function save(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::create($request->all());

            DB::commit();
            return response()->json($user, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving user failed: " . $e->getMessage(), 420);
        }
    }


    public function updateUser(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = User::get()->where('id', $id)->first();
            if ($user != null) {
                $user->update($request->all());
            }
            DB::commit();
            $u = User::get()->where('id', $id)->first();

            return response()->json($u, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating user failed: " . $e->getMessage(), 420);
        }
    }

}
