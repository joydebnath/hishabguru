<?php

namespace App\Http\Controllers\ImportData;

use App\Http\Controllers\Controller;
use App\Services\ImportData\ImportService;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    protected $service;

    public function __construct(ImportService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {
            return $this->service::getImportFactory($request->type)->import($request->records);
        } catch (\Exception $exception) {
            return response(['error' => $exception->getMessage()], 500);
        }
    }
}
