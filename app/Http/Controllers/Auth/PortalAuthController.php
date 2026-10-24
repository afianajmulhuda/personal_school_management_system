<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash as FacadesHash;

class PortalAuthController extends Controller
{
    /**
     * Render the custom gradient login layout frame screen.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Process incoming terminal login authentications requests.
     */
    public function login(Request $request)
    {
        // 1. Validate form fields
        $credentials = $request->validate([
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // 2. Attempt authentication verification against database layer logs
        if (Auth::attempt($credentials, $remember)) {
            // Regenerate session tokens to defend against fixation cyber attacks
            $request->session()->regenerate();

            // Send user to their intended destination page, or fallback to main administrative workspace
            return redirect()->intended('/dashboard');
        }

        // 3. Fallback tracking error response stack if mismatch occurs
        return back()->withErrors([
            'email' => 'The provided security credentials do not match our identity index logs.',
        ])->onlyInput('email');
    }

    /**
     * Render the custom registration provisioning form profile page.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Process data parameters to provision a new operator workspace identity record.
     */
    public function register(Request $request)
    {
        // 1. Enforce strict server side parameters matching the template components
        $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'terms'      => ['required', 'accepted']
        ]);

        // 2. Provision and write database rows safely using structural layout models
        $user = User::create([
            'name'     => $request->first_name . ' ' . $request->last_name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Auto-login the newly registered network profile account node instantly
        Auth::login($user);

        // 4. Safely redirect directly into master navigation portal array engine screens
        return redirect('/dashboard')->with('success', 'Terminal authentication profile successfully provisioned!');
    }

    /**
     * Disconnect terminal context access logs and destroy current session frame.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}