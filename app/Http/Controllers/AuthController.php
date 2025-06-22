<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    protected function validator(array $data, $role = 'user')
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Tambahan validasi untuk seller
        if ($role === 'seller') {
            $rules['store_name'] = ['required', 'string', 'max:255'];
            $rules['store_address'] = ['required', 'string', 'max:500'];
            $rules['store_description'] = ['nullable', 'string', 'max:1000'];
        }

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'store_name.required' => 'Nama toko wajib diisi.',
            'store_name.max' => 'Nama toko maksimal 255 karakter.',
            'store_address.required' => 'Alamat toko wajib diisi.',
            'store_address.max' => 'Alamat toko maksimal 500 karakter.',
            'store_description.max' => 'Deskripsi toko maksimal 1000 karakter.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    protected function create(array $data, $role = 'user')
    {
        return DB::transaction(function () use ($data, $role) {
            // Buat user terlebih dahulu
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'role' => $role,
            ]);

            // Jika role seller, buat data seller
            if ($role === 'seller') {
                Seller::create([
                    'user_id' => $user->id,
                    'store_name' => $data['store_name'],
                    'store_address' => $data['store_address'],
                    'store_description' => $data['store_description'] ?? null,
                    'is_verified' => false,
                    'is_suspended' => false,
                ]);
            }

            return $user;
        });
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showSellerRegistrationForm()
    {
        return view('auth.register-seller');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            // Cek jika seller apakah suspended
            // if ($user->isSeller() && $user->isSellerSuspended()) {
            //     Auth::logout();
            //     return back()->withErrors([
            //         'email' => 'Akun seller Anda telah dinonaktifkan. Silakan hubungi admin.',
            //     ])->withInput($request->except('password'));
            // }

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin')->with('success', 'Selamat datang, Admin!');
                case 'seller':
                    return redirect()->intended('/seller/dashboard')->with('success', 'Selamat datang kembali, Seller!');
                default:
                    return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak cocok.',
        ])->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all(), 'user')->validate();

        $user = $this->create($request->all(), 'user');

        // Auto login setelah register
        Auth::login($user);

        return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat datang di Furnie.');
    }

    public function registerSeller(Request $request)
    {
        $this->validator($request->all(), 'seller')->validate();

        $user = $this->create($request->all(), 'seller');

        // Auto login setelah register
        Auth::login($user);

        return redirect('/seller/dashboard')->with('success', 'Akun seller berhasil dibuat! Menunggu verifikasi admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}