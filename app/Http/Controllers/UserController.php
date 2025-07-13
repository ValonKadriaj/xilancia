<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $hashedPassword = Hash::make($validated['password']);
        try {
            DB::statement("CALL create_user(?, ?, ?, ?)", [
                $validated['first_name'],
                $validated['last_name'],
                $validated['email'],
                $hashedPassword,
            ]);

            return response()->json(['message' => 'User created successfully'], 201);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to create user'], 500);
        }
    }
    public function index(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $offset = ($page - 1) * $perPage;
            $users = DB::select("CALL get_all_users(?, ?)", [$offset, $perPage]);
            return response()->json($users);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch users'], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = DB::select("CALL get_user_by_id(?)", [$id]);

            if (empty($user)) {
                return response()->json(['message' => 'User not found'], 404);
            }

            return response()->json($user[0]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch user'], 500);
        }
    }

    public function update(StoreUserRequest $request, $id)
    {
        $validated = $request->validated();
        $hashedPassword = Hash::make($validated['password']);
        try {
            DB::statement("CALL update_user(?, ?, ?, ?, ?)", [
                $id,
                $validated['first_name'],
                $validated['last_name'],
                $validated['email'],
                $hashedPassword
            ]);

            return response()->json(['message' => 'User updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Failed to update user'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::statement("CALL delete_user(?)", [$id]);
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
}
