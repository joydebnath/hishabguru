<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function show(Quotation $quotation)
    {
        return view('guest.quotation');
    }
}
