<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\InternalPromoCode;
use App\Models\Role;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
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

    public function showRegistrationForm()
    {
        if(config('hishabguru.signup_require_promo_code') && request()->promo === null){
            return view('auth.register-checkpost');
        }

        return view('auth.register');
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
            'promo_code' => [config('hishabguru.signup_require_promo_code') ? 'required' : 'nullable', 'string'],
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
        $promoCodeIsEnabled = config('hishabguru.signup_require_promo_code');
        if ($promoCodeIsEnabled) {
            $code = $this->registerPromoCode($data['promo_code']);
            if ($code === null) {
                return $this->throwInvalidPromoCodeError();
            }
        }

        $user = $this->createUser($data);

        $tenant = $this->createTenant($data);

        $this->attachUserToTenant($user, $tenant);

        $this->updateUserCurrentTenancy($user, $tenant);

        if ($promoCodeIsEnabled) {
            $this->attachUserWithPromoCode($user, $code);
        }

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

    private function registerPromoCode($code)
    {
        $promo = InternalPromoCode::where([
            ['code', '=', strtolower($code)],
            ['expiry_date', '<=', Carbon::today()->endOfDay()],
        ])->first();

        if ($promo && ($promo->total_count > $promo->total_used_count)) {
            return $promo;
        }

        return null;
    }

    private function attachUserWithPromoCode(User $user, InternalPromoCode $code)
    {
        $code->users()->attach($user->id);
        $code->update([
            'total_used_count' => ($code->total_used_count + 1)
        ]);
    }

    private function throwInvalidPromoCodeError()
    {
        return Validator::make(['promo_code' => ''], [
            'promo_code' => ['required', 'string'],
        ], [
            'required' => 'The :attribute value is invalid.',
        ])->validate();
    }

    protected function registered(Request $request, $user)
    {
        Auth::logout();
    }
}
