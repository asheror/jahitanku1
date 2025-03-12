<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
{
    $query = User::query();

    // Filter by role if selected
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    // Search by email if provided
    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    $users = $query->get();

    return view('admin.UserManagement', compact('users'));
}


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'registration_date' => 'required|date',
            'role' => 'required|string|in:user,admin', // Validasi role
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->registration_date = $request->registration_date;
        $user->role = $request->role; // Set role
        $user->save();

        return redirect()->route('usermanagement.index')->with('success', 'User added successfully');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:3',
            'phone_number' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'registration_date' => 'required|date',
            'role' => 'required|string|in:user,admin', // Validasi role
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'registration_date' => $request->registration_date,
            'role' => $request->role, // Update role
        ]);

        return redirect()->route('usermanagement.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('usermanagement.index')->with('success', 'User deleted successfully');
    }
}
