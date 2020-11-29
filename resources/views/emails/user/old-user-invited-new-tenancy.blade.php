@component('mail::message')
    ## Join request...

    Dear {{$user->name}},

    You have been invited by {{$invitedBy->name}} to join {{$tenant->name}} as {{$role->name}}.

@component('mail::button', ['url' => 'https://www.hishabguru.com/login', 'color' => 'primary','align'=>'left'])
    Sign In
@endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
