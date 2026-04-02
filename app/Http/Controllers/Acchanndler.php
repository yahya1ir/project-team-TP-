<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Acchanndler extends Controller
{
    // settings view
    public function settings(){
        return view('settings');
    }

    // Update password (settings)
    public function password(Request $request){
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Check if current password is correct
        if (!Hash::check($validated['current_password'], auth()->user()->password)) {
            return back()->withErrors(['current_password' => __('messages.password.incorrect')]);
        }

        // Update password
        $user = auth()->user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', __('messages.password.updated'));
    }
}
