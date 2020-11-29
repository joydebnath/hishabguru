<?php

namespace App\Mail\User;

use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserInvitedToNewTenancyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user, $tenant, $role, $tempPassword, $invitedBy;

    public function __construct(User $user, Tenant $tenant, Role $role, string $tempPassword, $invitedBy)
    {
        $this->user = $user;
        $this->tenant = $tenant;
        $this->role = $role;
        $this->invitedBy = $invitedBy;
        $this->tempPassword = $tempPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.new-user-invited-new-tenancy')->with([
            'user' => $this->user,
            'tenant' => $this->tenant,
            'role' => $this->role,
            'password' => $this->tempPassword,
            'invitedBy' => $this->invitedBy,
        ])->subject($this->tenant->name . ' has invited you to join ' . config('app.name') . '!');
    }
}
