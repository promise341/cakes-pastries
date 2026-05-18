<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserManagerController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', "You cannot toggle your own administrative access!");
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? "granted administrative access" : "restricted to regular customer";

        return back()->with('success', "User '{$user->name}' was successfully {$status}.");
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', "Self-deletion is prohibited in this administrative session.");
        }

        $name = $user->name;
        $user->delete();
        return back()->with('success', "User account '{$name}' has been permanently terminated.");
    }
}
