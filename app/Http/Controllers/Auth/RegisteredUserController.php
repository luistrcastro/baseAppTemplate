<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'first_name' => ['required', 'string', 'max:80'],
            'middle_name' =>  ['nullable', 'string', 'max:80'],
            'last_name' =>  ['required', 'string', 'max:80'],
            'full_name' => ['nullable', 'string', 'max:240'],
            'picture_url' => ['nullable', 'string', 'max:255'],
            'receives_browser_notifications' =>  ['nullable', 'boolean'],
            'receives_email_notifications' =>  ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'full_name' => $request->full_name || $request->first_name . ' ' . $request->last_name,
            'picture_url' => $request->picture_url,
            'receives_browser_notifications' => $request->receives_browser_notifications,
            'receives_email_notifications' => $request->receives_email_notifications,
        'password',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
