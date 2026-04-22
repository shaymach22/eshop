<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $user = auth()->user();
        $data = $request->only('name', 'phone', 'address');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::delete('public/' . $user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Mot de passe modifié.');
    }
}