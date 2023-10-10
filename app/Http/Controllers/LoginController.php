<?php

namespace App\Http\Controllers;


//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\HashableService;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiBaseController
{
    use Authenticatable;

    public function me(Request $request) {
        $user = $request->user();
        $user->id = HashableService::getHash(Auth::user()->getKey(), 'User');
        return $user;
    }
}
