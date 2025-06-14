<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Auth::user()->getRoleNames();
        return view('cms.pilihRole', compact('roles'));
    }

    public function setActiveRole(Request $request)
    {
        $role = $request->input('role');

        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Tidak Memiliki Role.');
        }

        session(['active_role' => $role]);

        return match ($role) {
            'pegawai' => redirect()->route('view-profile'),
            'super admin', 'hrd', 'keuangan' => redirect()->route('dashboard'),
            default => redirect()->route('view-pilih-role'),
        };
    }
    // Reset role aktif
    public function resetActiveRole(Request $request)
    {
        $request->session()->forget('active_role');
        return redirect()->route('view-pilih-role');
    }
}


