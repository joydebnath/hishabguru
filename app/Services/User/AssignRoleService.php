<?php

namespace App\Services\User;

use App\Enums\Contact\ContactDetailsType;
use App\Models\Contact;
use App\Models\ContactDetail;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AssignRoleService
{
    protected $password, $userAlreadyExists;

    public function __construct()
    {
        $this->userAlreadyExists = false;
        $this->password = null;
    }

    public function addOrUpdateEmail(Contact $employee, string $email)
    {
        ContactDetail::updateOrCreate([
            'contact_id' => $employee->id,
            'key' => ContactDetailsType::EMAIL
        ], [
            'value' => $email
        ]);
    }

    public function assignRole(Contact $employee, array $storable)
    {
        $user = $this->getUser($employee, $storable['email']);
        $tenant = $employee->tenant;
        $this->attachUserToTenant($user, $tenant, $storable['system_role']);
        $this->updateUserCurrentTenancy($user, $tenant);
        $this->inviteUser($user, $tenant);
    }

    private function getUser(Contact $employee, string $email): User
    {
        $user = User::firstWhere('email', $email);
        if (collect($user)->isNotEmpty()) {
            $this->userAlreadyExists = true;
            return $user;
        }

        $this->password = Str::random(8);

        return $this->createUser([
            'name' => $employee->name,
            'email' => $email,
            'password' => $this->password
        ]);
    }

    private function createUser(array $data)
    {
        return User::firstOrCreate([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    private function attachUserToTenant(User $user, Tenant $tenant, string $role)
    {
        $role = Role::firstWhere('slug', $role);
        $user->tenants()->attach($tenant->id, ['role_id' => $role->id]);
    }

    private function updateUserCurrentTenancy($user, $tenant)
    {
        if ($user->current_tenant_id === null) {
            $user->update(['current_tenant_id' => $tenant->id]);
        }
    }

    private function inviteUser(User $user, Tenant $tenant)
    {
        if ($this->userAlreadyExists) {
            //dispatch you are invited by tenant - please accept
        }
        //dispatch you are invited by tenant - please log in with temp password and change
    }
}
