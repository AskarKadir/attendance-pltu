<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $formattedEmail = ''; // Initialize the formatted email as an empty string
        return view('auth.register', compact('formattedEmail'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator      = Validator::make($request->all(), [
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $validatorEmail = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
        ]);

        if ($validatorEmail->fails()) {
            return redirect()->back()->with('email_exists', 'Email already exists.');
        }
        if ($validator->fails()) {
            return redirect()->back()->with('password', 'Password must have 8 character');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}