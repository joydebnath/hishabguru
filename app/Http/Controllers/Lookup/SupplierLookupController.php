<?php

namespace App\Http\Controllers\Lookup;

use App\Enums\Contact\ContactType;
use App\Filters\Contact\SupplierLookupFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\SupplierLookupCollection;
use App\Models\Contact;
use Exception;

class SupplierLookupController extends Controller
{
    public function index(SupplierLookupFilter $filters)
    {
        try {
            return new SupplierLookupCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::SUPPLIER)
                    ->with('emails', 'mobiles', 'addresses')
                    ->limit(15)
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], intval($exception->getCode()));
        }
    }
}
