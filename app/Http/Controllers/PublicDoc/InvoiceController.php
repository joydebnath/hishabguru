<?php

namespace App\Http\Controllers\PublicDoc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($invoiceId)
    {
        return view('guest.invoice');
    }
}
