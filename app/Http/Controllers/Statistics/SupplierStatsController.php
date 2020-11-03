<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierStatsController extends Controller
{
    public function getLastTwelvemonthCounts($supplierId)
    {
        return [];
    }

    public function getDueInvoices($supplierId)
    {
        return [];
    }

    public function getPaidInvoices($supplierId)
    {
        return [];
    }
}
