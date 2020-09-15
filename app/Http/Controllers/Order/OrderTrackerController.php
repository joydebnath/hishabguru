<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderTrackerController extends Controller
{
    public function index()
    {
        $orderId = request()->order_id;
        return view('order.tracker', compact('orderId'));
    }
}
