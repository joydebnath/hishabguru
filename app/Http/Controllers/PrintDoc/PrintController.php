<?php

namespace App\Http\Controllers\PrintDoc;

use App\Http\Controllers\Controller;
use App\Services\PrintDoc\PrintFactory;

class PrintController extends Controller
{
    public function show($type, $id)
    {
        return PrintFactory::getEngineer($type, $id)->build();
    }
}
