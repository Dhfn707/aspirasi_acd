<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        // Query user dari database absen_karyawan dengan relasi ke user_roles
        $user = DB::connection('absen_karyawan')
            ->table('user')
            ->join('user_roles', 'user.role_id', '=', 'user_roles.id')
            ->where('user.email', $validated['email'])
            ->first(['user.id', 'user.name', 'user.email', 'user.password', 'user.role_id', 'user_roles.name as role_name']);

        // Check if user exists
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->onlyInput('email');
        }

        // Check password
        if (!Hash::check($validated['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        // Store user session
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role_id' => $user->role_id,
            'user_role_name' => $user->role_name,
        ]);

        // Redirect based on role name
        $roleName = strtolower($user->role_name);

        if ($roleName === 'admin') {
            // Admin role
            session(['user_type' => 'admin']);
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil sebagai Admin');
        } else {
            // Karyawan role
            session(['user_type' => 'karyawan']);
            return redirect()->route('aspirasi.index')->with('success', 'Login berhasil sebagai Karyawan');
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
