<?php

namespace App\Http\Controllers\PrintDoc;

use App\Http\Controllers\Controller;
use App\Services\PrintDoc\PrintDocService;
use App\Services\PrintDoc\PrintFactory;

class PrintController extends Controller
{
    protected $service;

    public function __construct(PrintDocService $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return $this->service->generate();
    }

    public function print($type, $id)
    {
        return PrintFactory::getEngineer($type, $id)->build();
    }
}
