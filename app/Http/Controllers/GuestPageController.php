<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestPageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function welcome()
    {
        return view('guest.email-verification-sent');
    }

    public function hasNoTenacy()
    {
        return view('guest.void-account');
    }

    public function share()
    {
        try {
            $query_decoded = base64_decode(request()->get('q'));
            $result = json_decode($query_decoded, true);

            if ($result === null) {
                abort(404);
            }

            $result['type'];
            $result['id'];
        } catch (\Exception $exception) {
            abort(404);
        }
    }
}
