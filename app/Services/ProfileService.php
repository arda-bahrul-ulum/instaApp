<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Exception;

class ProfileService
{
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->fill($request->validated());
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        return $user;
    }

    public function deleteProfile(Request $request)
    {
        $user = $request->user();
        \Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return true;
    }
}
