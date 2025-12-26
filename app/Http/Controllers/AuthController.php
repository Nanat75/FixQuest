<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('teknisi.dashboard');
        }
    }

    return back()->withErrors(['login' => 'UH OH! Email atau Password Anda salah... Silahkan coba lagi.']);
}


    public function showRegister()
    {
        return view('auth.register');
    }
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required',
        'token' => 'nullable|string',
    ]);

    // Handle Admin Token
    if ($request->role === 'admin') {
        if ($request->token !== 'SECRET-ADMIN-TOKEN') {
            return back()->withErrors(['token' => 'UH OH! Token Anda Salah... Silahkan coba lagi.'])->withInput();
        }
    }

    // Create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    Auth::login($user);

    return $request->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('teknisi.dashboard');
}
}