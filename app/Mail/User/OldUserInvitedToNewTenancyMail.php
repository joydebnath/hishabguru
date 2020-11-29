<?php

namespace App\Mail\User;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OldUserInvitedToNewTenancyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user, $tenant, $role, $invitedBy;

    public function __construct(User $user, Tenant $tenant, Role $role, $invitedBy)
    {
        $this->user = $user;
        $this->invitedBy = $invitedBy;
        $this->tenant = $tenant;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.old-user-invited-new-tenancy')->with([
            'user' => $this->user,
            'tenant' => $this->tenant,
            'role' => $this->role,
            'invitedBy' => $this->invitedBy,
        ])->subject('A new Role has been assigned to you @' . $this->tenant->name);
    }
}
