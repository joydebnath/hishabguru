<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientStatsController extends Controller
{
    public function getLastTwelvemonthCounts($clientId)
    {
        return [];
    }

    public function getDueInvoices($clientId)
    {
        return [];
    }

    public function getPaidInvoices($clientId)
    {
        return [];
    }
}
