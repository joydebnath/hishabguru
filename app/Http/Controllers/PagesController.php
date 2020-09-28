<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnexpectedSessionUsageException;

class PagesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
//        if($user->email_verified_at === null){
//            return view('welcome');
//        }
        return view('spa');
    }
}
