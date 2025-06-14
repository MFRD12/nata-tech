<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class akunController extends Controller
{
    public function index(Request $request)
    {
        $usersList = User::with(['roles', 'pegawai']);

        // fungsi search (nip, email, atau nama pegawai)
        if ($request->filled('search')) {
            $search = $request->search;
            $usersList->where(function ($cari) use ($search) {
                $cari->where('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('pegawai', function ($carinama) use ($search) {
                        $carinama->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // fungsi filter role
        if ($request->filled('role')) {
            $usersList->whereHas('roles', function ($filter) use ($request) {
                $filter->where('name', $request->role);
            });
        }

        $perPage = $request->input('perPage', 10);
        $users = $usersList->paginate($perPage)->withQueryString();
        $roles = Role::all();

        return view('cms.admin.pengaturan.akun', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_context' => 'required|string|in:add_akun',
            'nip' => 'required|unique:users,nip',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'roles' => 'required|array'
        ], [
            'nip.unique' => 'NIP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'roles.required' => 'Pilih minimal satu role.'
        ]);

        $user = User::create([
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('view-akun', [
            'search' => $request->search,
            'role' => $request->role,
            'page' => $request->page,
            'perPage' => $request->perPage
        ])->with('success', 'Akun berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'form_context' => 'required|string|in:update_akun_' . $user->id,
            'nip' => 'required|unique:users,nip,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array'
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'confirmed|min:8';
        }

        $request->validate($rules, [
            'nip.unique' => 'NIP sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'roles.required' => 'Pilih minimal satu role.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.'
        ]);

        $user->update([
            'nip' => $request->nip,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Cegah user menghapus role super admin dari akun sendiri
        if (Auth::user()->id == $user->id && !in_array('super admin', $request->roles)) {
            return back()->with('error', 'Dilarang menghapus role super admin dari akunmu sendiri.');
        }

        // CEGAH semau role super admin hilang
        if ($user->hasRole('super admin')) {
            $superAdminCount = User::role('super admin')->count();
            if ($superAdminCount <= 1 && !in_array('super admin', $request->roles)) {
                return back()->with('error', 'Minimal harus ada satu akun dengan role super admin.');
            }
        }

        $user->syncRoles($request->roles);

        return redirect()->route('view-akun', [
            'search' => $request->search,
            'role' => $request->role,
            'page' => $request->page,
            'perPage' => $request->perPage
        ])->with('success', 'Akun berhasil diupdate.');
    }

}
