<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function welcome()
    {
        return view('guest.email-verification-sent');
    }

    public function hasNoTenacy()
    {
        return view('guest.void-account');
    }
}
