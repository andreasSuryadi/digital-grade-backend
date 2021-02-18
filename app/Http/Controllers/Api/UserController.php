<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfoFromToken(Request $request)
    {
        $authenticatedUser = $request->user();
        $user = User::where('id', '=', $authenticatedUser->id);

        return response()->json([
            'id' => $authenticatedUser->id,
            'nip' => $authenticatedUser->nip,
            'nis' => $authenticatedUser->nis,
            'nisn' => $authenticatedUser->nisn,
            'first_name' => $authenticatedUser->first_name,
            'last_name' => $authenticatedUser->last_name,
            'phone_number' => $authenticatedUser->phone_number,
            'email' => $authenticatedUser->email,
            'place_of_birth' => $authenticatedUser->place_of_birth,
            'date_of_birth' => $authenticatedUser->date_of_birth,
            'gender' => $authenticatedUser->gender,
            'profile_picture_url' => $authenticatedUser->profile_picture_url ? '/storage/users/' . $authenticatedUser->id . '/profile/' . $authenticatedUser->profile_picture_url : null,
            'address' => $authenticatedUser->address,
            'blood_type' => $authenticatedUser->blood_type,
            'role' => $authenticatedUser->role,
        ], 200);
    }
}
