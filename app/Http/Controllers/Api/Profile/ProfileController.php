<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
    
        $hour = Carbon::now()->format('H');
        $greeting = $this->getGreetingMessage($hour);
    
        return response()->json([
            'success' => true,
            'message' => "{$greeting}, {$user->name}!",
            'user' => [
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }

    // Fungsi untuk mendapatkan pesan salam berdasarkan jam
    private function getGreetingMessage($hour)
    {
        if ($hour >= 5 && $hour < 12) {
            return "Selamat Pagi 🌅";
        } elseif ($hour >= 12 && $hour < 15) {
            return "Selamat Siang ☀️";
        } elseif ($hour >= 15 && $hour < 18) {
            return "Selamat Sore 🌇";
        } else {
            return "Selamat Malam 🌙";
        }
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $user->update($request->only(['name', 'email', 'password']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }

 
    public function destroy()
    {
        $user = Auth::user();
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been deleted'
        ]);
    }
    
}
