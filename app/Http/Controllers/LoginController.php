<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            '_token' => ['required'],
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
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
     * Destroy an authenticated session.
     *
     * @route GET /logout logout
     * @route POST /logout
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        /**
         * @var Authenticatable $user
         */
        $user = $request->user();

        if ($user) {
            $this->destroyTokens($user, $request);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            $data = [
                'message' => __('logout'),
                'everywhere' => $request->has('all') || $request->has('everywhere'),
                'csrf_token' => csrf_token(),
            ];

            return response()->json($data);
        }

        return redirect('/');
    }

    protected function destroyTokens(
        Authenticatable $user,
        Request $request,
    ): void {
        if ($request->has('all') || $request->has('everywhere')) {
            if (is_callable([$user, 'tokens'])) {
                $user->tokens()->delete();
            }
        } else {
            if (is_callable([$user, 'currentAccessToken'])) {
                /**
                 * @var ?PersonalAccessToken $token
                 */
                $token = $user->currentAccessToken();
                $token?->delete();
            }
        }
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
