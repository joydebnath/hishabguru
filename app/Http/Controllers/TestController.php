<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function index()
    {
//        Mail::to(User::find(1))->send(new TestMail());
    }
}
