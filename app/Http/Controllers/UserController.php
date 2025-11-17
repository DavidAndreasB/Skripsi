<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    // Tampilkan daftar semua pengguna
    public function index()
    {
        $users = User::all();
        $roles = [
            User::ROLE_SUPER_ADMIN => 'Super Admin',
            User::ROLE_QUALITY_CONTROL => 'Quality Control',
            User::ROLE_OPERATOR => 'Operator',
        ];
        return view('user.index', compact('users', 'roles')); 
    }

    // Tampilkan form untuk membuat pengguna baru
    public function create()
    {
        $roles = [
            User::ROLE_SUPER_ADMIN => '1. Admin (Super Admin)',
            User::ROLE_QUALITY_CONTROL => '2. Quality Control (QC)',
            User::ROLE_OPERATOR => '3. Operator',
        ];
        return view('user.create', compact('roles'));
    }
    
    // Menyimpan data pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:'.User::class], 
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'integer', Rule::in([User::ROLE_SUPER_ADMIN, User::ROLE_QUALITY_CONTROL, User::ROLE_OPERATOR])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => null, // TIDAK MENGGUNAKAN EMAIL
            'password' => Hash::make($request->password),
            'role' => (int) $request->role, 
        ]);

        return Redirect::route('user.index')->with('status', 'Akun pengguna **' . $request->name . '** berhasil didaftarkan.');
    }
}