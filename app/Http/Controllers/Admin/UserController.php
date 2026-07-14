<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->withCount('orders');

        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        if ($search = $request->get('q')) {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        abort_if($user->isAdmin(), 403, 'Tidak bisa menghapus akun admin.');
        $user->delete();

        return back()->with('status', 'Pengguna dihapus.');
    }
}
