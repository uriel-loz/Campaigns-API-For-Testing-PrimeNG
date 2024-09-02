<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) : object
    {
        $request->validate([
            'page' => 'integer|min:1',
            'size' => 'integer|min:1',
            'sort_field' => 'string',
            'order' => 'integer',
        ]);

        $order = $request->order < 0 ? 'desc': 'asc';
        $filters = $request->filters ?? [];

        $filters = convertToArrayFilter($filters);

        $campaigns = User::where(function($query) use ($filters): void {
            foreach ($filters as $key => $value) {
                $query->where($key, 'LIKE', "%{$value}%");
            }
        })
        ->orderBy($request->sort_field, $order)
        ->paginate($request->size, ['*'], 'page', $request->page);

        return response()->json($campaigns);
    }

    public function store(Request $request) : object
    {
        try {
            Validator::make($request->all(), [
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
            ])->validate();

            $user = User::create($request->all());

            return response()->json($user, 201);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function show(User $user) : object
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user) : object
    {
        try {
            Validator::make($request->all(), [
                'name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email',
            ])->validate();

            $user->update($request->all());

            return response()->json($user);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    public function destroy(User $user) : object
    {
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}