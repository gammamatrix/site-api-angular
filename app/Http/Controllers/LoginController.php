<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if ($request->expectsJson()) {

                /**
                 * @var Authenticatable $user
                 */
                $user = $request->user();

                $payload = [
                    'message' => 'Authenticated',
                    'csrf_token' => csrf_token(),
                    'token' => $user->createToken(
                        'app',
                        ['*'],
                    )->plainTextToken,
                ];

                return response()->json($payload);
            }

            return redirect()->intended('dashboard');
        }

        if ($request->expectsJson()) {
            $payload = [
                'errors' => [
                    'email' => 'The provided credentials do not match our records.',
                ],
            ];
            return response()->json($payload, 422);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Return a CSRF token.
     *
     * @route GET /token token
     */
    public function token(Request $request): JsonResponse
    {
        return response()->json([
            'token' => csrf_token(),
        ]);
    }
}