<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Centars;
use App\Models\Marka;
use App\Enums\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['centar'])->where('role', Roles::AGENT)->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $centars = Centars::all();
        $markas = Marka::all();
        return view('admin.users.create', compact('centars', 'markas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'centar_id' => 'nullable|exists:centars,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'centar_id' => $request->centar_id,
            'ashon_id' => 1,
            'role' => Roles::AGENT,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Agent created successfully.');
    }

    public function edit(User $user)
    {
        $centars = Centars::all();
        $markas = Marka::all();
        return view('admin.users.edit', compact('user', 'centars', 'markas'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'centar_id' => 'nullable|exists:centars,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'centar_id' => $request->centar_id,
            'ashon_id' => 1,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Agent deleted successfully.');
    }
}
