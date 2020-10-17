<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return new UserResource(Auth::user()->load('tenants.user_roles'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $checkpoint = Hash::check($request->current_password, $user->getAuthPassword());

        if ($checkpoint) {
            $storable = $request->validate([
                'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user->update([
                'password' => Hash::make($storable['new_password']),
            ]);

            return response(['message' => 'Password Updated!'], 201);
        }

        return response(['message' => 'Credential does not match'], 401);
    }

    public function destroy(User $user)
    {
        //
    }
}
