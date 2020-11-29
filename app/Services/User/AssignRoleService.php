<?php

namespace App\Services\User;

use App\Enums\Contact\ContactDetailsType;
use App\Mail\User\NewUserInvitedToNewTenancyMail;
use App\Mail\User\OldUserInvitedToNewTenancyMail;
use App\Models\Contact;
use App\Models\ContactDetail;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        $tenant = $employee->tenant;
        $user = $this->getUser($employee, $storable['email']);
        $role = $this->attachUserToTenantWithRole($user, $tenant, $storable['system_role']);
        $this->updateUserCurrentTenancy($user, $tenant);
        $this->inviteUser($user, $tenant, $role);
    }

    private function getUser(Contact $employee, string $email): User
    {
        $user = User::firstWhere('email', $email);
        if (collect($user)->isNotEmpty()) {
            $this->userAlreadyExists = true;
            return $user;
        }

        $this->password = Str::random(8);

        return User::create([
            'name' => $employee->name,
            'email' => $email,
            'password' => Hash::make($this->password),
        ]);
    }

    private function attachUserToTenantWithRole(User $user, Tenant $tenant, string $roleSlug): Role
    {
        $role = Role::firstWhere('slug', $roleSlug);
        $tenant->user_roles()->sync($user->id, [
            'role_id' => $role->id,
            'permissions' => $role->permissions
        ]);
        return $role;
    }

    private function updateUserCurrentTenancy($user, $tenant)
    {
        if ($user->current_tenant_id === null) {
            $user->update(['current_tenant_id' => $tenant->id]);
        }
    }

    private function inviteUser(User $user, Tenant $tenant, Role $role)
    {
        $invitedBy = Auth::user();

        if ($this->userAlreadyExists) {
            Mail::to($user)->send(new OldUserInvitedToNewTenancyMail($user, $tenant, $role, $invitedBy));
            return true;
        }

        Mail::to($user)->send(new NewUserInvitedToNewTenancyMail($user, $tenant, $role, $this->password, $invitedBy));
    }
}
