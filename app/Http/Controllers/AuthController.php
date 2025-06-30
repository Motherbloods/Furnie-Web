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
use Illuminate\Validation\Rule;

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

            // Cek apakah user di-suspend
            if (isset($user->is_suspended) && $user->is_suspended) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin untuk informasi lebih lanjut.',
                ])->withInput($request->except('password'));
            }

            // Cek jika seller apakah suspended
            if ($user->isSeller() && $user->isSellerSuspended()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun seller Anda telah dinonaktifkan. Silakan hubungi admin.',
                ])->withInput($request->except('password'));
            }

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

    public function showProfileEdit()
    {
        $user = Auth::user();

        // Load seller relationship if user is a seller
        if ($user->isSeller()) {
            $user->load('seller');
        }

        return view('auth.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
        ];

        // Add seller validation rules if user is a seller
        if ($user->isSeller()) {
            $rules = array_merge($rules, [
                'store_name' => ['nullable', 'string', 'max:255'],
                'store_address' => ['nullable', 'string', 'max:1000'],
                'store_description' => ['nullable', 'string', 'max:2000'],
            ]);
        }

        // Add password validation rules if password fields are filled
        if ($request->filled('current_password') || $request->filled('password')) {
            $rules = array_merge($rules, [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }

        // Custom validation messages
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'store_name.max' => 'Nama toko maksimal 255 karakter.',
            'store_address.max' => 'Alamat toko maksimal 1000 karakter.',
            'store_description.max' => 'Deskripsi toko maksimal 2000 karakter.',
            'current_password.required' => 'Password saat ini wajib diisi untuk mengubah password.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];

        // Validate the request
        $validated = $request->validate($rules, $messages);

        try {
            // Check current password if trying to change password
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors([
                        'current_password' => 'Password saat ini tidak benar.'
                    ])->withInput();
                }
            }

            // Update user data
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
            ];

            // Add new password if provided
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            // Update seller data if user is a seller
            if ($user->isSeller()) {
                $sellerData = [
                    'store_name' => $validated['store_name'] ?? null,
                    'store_address' => $validated['store_address'] ?? null,
                    'store_description' => $validated['store_description'] ?? null,
                ];

                // Create or update seller profile
                if ($user->seller) {
                    $user->seller->update($sellerData);
                } else {
                    // Create new seller profile if doesn't exist
                    $sellerData['user_id'] = $user->id;
                    $sellerData['is_verified'] = false;
                    $sellerData['is_suspended'] = false;
                    Seller::create($sellerData);
                }
            }

            return redirect()->route('profile.view')
                ->with('success', 'Profile berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui profile. Silakan coba lagi.'
            ])->withInput();
        }
    }

    public function profile()
    {
        $user = Auth::user();
        // Load seller relationship if user is a seller
        if ($user->isSeller()) {
            $user->load('seller');
        }

        return view('auth.profile-page', compact('user'));
    }
}