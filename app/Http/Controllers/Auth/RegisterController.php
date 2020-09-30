<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/almost-there';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'business_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = $this->createUser($data);

        $tenant = $this->createTenant($data);

        $this->attachUserToTenant($user, $tenant);

        $this->updateUserCurrentTenancy($user, $tenant);

        return $user;
    }

    private function createUser(array $data)
    {
        return User::firstOrCreate([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    private function createTenant($data)
    {
        return Tenant::create([
            'name' => $data['business_name']
        ]);
    }

    private function attachUserToTenant($user, $tenant)
    {
        $role = Role::where('slug', 'admin')->first();
        $user->tenants()->attach($tenant->id, ['role_id' => $role->id]);
    }

    private function updateUserCurrentTenancy($user, $tenant)
    {
        if ($user->current_tenant_id === null) {
            $user->update(['current_tenant_id' => $tenant->id]);
        }
    }

    protected function registered(Request $request, $user)
    {
        Auth::logout();
    }
}
