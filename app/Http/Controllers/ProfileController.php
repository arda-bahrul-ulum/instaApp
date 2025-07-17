<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, ProfileService $profileService): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $profileService->updateProfile($request);
            DB::commit();
            return Redirect::route('profile.edit')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::route('profile.edit')->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, ProfileService $profileService): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        DB::beginTransaction();
        try {
            $profileService->deleteProfile($request);
            DB::commit();
            return Redirect::to('/');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::route('profile.edit')->with('error', 'Failed to delete account: ' . $e->getMessage());
        }
    }
}
