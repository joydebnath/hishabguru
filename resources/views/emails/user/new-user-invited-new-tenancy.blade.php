@component('mail::message')
    ## Welcome to HishabGuru!

    Dear {{$user->name}},

    You have been invited by {{$invitedBy->name}} to join {{$tenant->name}} as {{$role->name}}.

    Your temporary password is {{$password}}.

    **Please change your password upon sign in. Click your name on top right corner. It will open a menu. From there, select profile option. Once your profile page is loaded, scroll down to bottom and there you will find change password option.

@component('mail::button', ['url' => 'https://www.hishabguru.com/@/profile', 'color' => 'primary','align'=>'left'])
    Sign In
@endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
