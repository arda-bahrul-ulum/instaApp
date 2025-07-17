<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, AuthService $authService): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $authService->register($request);
            DB::commit();
            return redirect(route('dashboard', absolute: false))->with('success', 'Registration successful! Welcome to InstaApp.');
        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'email' => $e->getMessage() ?: __('auth.failed'),
            ]);
        }
    }
}
