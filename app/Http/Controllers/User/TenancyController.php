<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\TenancyCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenancyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return new TenancyCollection($user->tenants->load('user_roles'));
    }
}
