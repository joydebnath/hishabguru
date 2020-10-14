<?php

namespace App\Http\Controllers\PrintDoc;

use App\Http\Controllers\Controller;
use App\Services\PrintDoc\PrintFactory;
use Exception;

class PrintController extends Controller
{
    public function publicAccess()
    {
        try {
            $decoded = json_decode(base64_encode(request()->query), true);
            return PrintFactory::getEngineer($decoded['type'], $decoded['id'])->build();
        } catch (Exception $exception) {
            abort(404);
        }
    }

    public function show($type, $id)
    {
        return PrintFactory::getEngineer($type, $id)->build();
    }
}
