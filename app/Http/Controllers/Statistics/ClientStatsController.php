<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Resources\Statistics\InvoiceDueCollection;
use App\Http\Resources\Statistics\InvoicePaidCollection;
use App\Services\Statistics\ClientStatService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;

class ClientStatsController extends Controller
{
    protected $service;

    public function __construct(ClientStatService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request, $clientId, $type)
    {
        $result = null;
        switch ($type) {
            case 'last-twelvemonth':
                $result = $this->getLastTwelvemonthCounts($clientId);
                break;
            case 'due-invoices':
                $result = $this->getDueInvoices($clientId);
                break;
            case 'paid-invoices':
                $result = $this->getPaidInvoices($request, $clientId);
                break;
            default:
                $result = response(['error' => 'Unsupported Statistic Type Provided'], 404);
        }
        return $result;
    }

    public function getLastTwelvemonthCounts($clientId)
    {
        try {
            return $this->service->getLastTwelvemonthInvoices($clientId);
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getDueInvoices($clientId)
    {
        try {
            return new InvoiceDueCollection(
                $this->service->getDueInvoices($clientId)
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }

    public function getPaidInvoices(Request $request, $clientId)
    {
        try {
            $start = Carbon::create($request->year, $request->month, 1)->startOfDay();
            $end = Carbon::create($request->year, $request->month)->endOfMonth()->endOfDay();
            return new InvoicePaidCollection(
                $this->service->getPaidInvoices($clientId, [$start, $end])
            );
        } catch (Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
