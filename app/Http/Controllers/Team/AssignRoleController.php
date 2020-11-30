<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\AssignRoleRequest;
use App\Http\Resources\Team\Employee;
use App\Models\Contact;
use App\Services\User\AssignRoleService;
use Illuminate\Http\Request;
use Exception;

class AssignRoleController extends Controller
{
    protected $service;

    public function __construct(AssignRoleService $service)
    {
        $this->service = $service;
    }

    public function update(AssignRoleRequest $request, $contactId)
    {
        try {
            return $request;
            $storable = $request->validated();
            $contact = Contact::find($contactId);

            $this->service->addOrUpdateEmail($contact, $storable['email']);
            $this->service->assignRole($contact, $storable);

            return new Employee($contact->fresh('emails', 'mobiles', 'jobTitle', 'currentlyWorking', 'addresses'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
