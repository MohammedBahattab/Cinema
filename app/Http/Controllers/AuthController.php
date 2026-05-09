<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // عرض تسجيل الدخول
    public function showLogin()
    {
        return view('auth.login');
    }
    // تسجيل حساب موجود
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // تحقق اذا كان مسؤول
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role && Auth::user()->role->name === 'admin') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    //انشاء حساب
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age' => ['nullable', 'integer', 'min:1'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $userRole = Role::where('name', 'user')->first();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $userRole ? $userRole->id : null,
            'age' => $validated['age'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
