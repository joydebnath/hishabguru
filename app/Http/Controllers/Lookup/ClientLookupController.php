<?php

namespace App\Http\Controllers\Lookup;

use App\Enums\Contact\ContactType;
use App\Filters\Contact\ClientLookupFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ClientLookupCollection;
use App\Models\Contact;
use Exception;

class ClientLookupController extends Controller
{
    public function index(ClientLookupFilter $filters)
    {
        try {
            return new ClientLookupCollection(
                Contact::filter($filters)
                    ->where('type', ContactType::CLIENT)
                    ->with('emails', 'mobiles', 'addresses')
                    ->limit(15)
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], intval($exception->getCode()));
        }
    }
}
