<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnexpectedSessionUsageException;

class PagesController extends Controller
{
    public function index()
    {
        return view('spa');
    }
}
