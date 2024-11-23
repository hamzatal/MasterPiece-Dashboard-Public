<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user is inactive
            if ($user->is_active == 0) {
                Auth::logout(); // Log out the inactive user
                return redirect()->route('login')->withErrors(['error' => 'Your account is inactive. Please contact support.']);
            }

            $userRoleId = $user->role_id;

            // Define role-based default route redirections
            $roleRedirects = [
                2 => 'dashboard',      // Admin role
                3 => 'welcome',        // User role
                4 => 'manager.home',
            ];

            // Get the default route for the user's role
            $defaultRoute = $roleRedirects[$userRoleId] ?? null;

            if ($defaultRoute) {
                // Redirect if the user tries to access an unauthorized route
                if (!$request->routeIs($defaultRoute) && !$this->isAuthorizedRoute($userRoleId, $request)) {
                    return redirect()->route($defaultRoute);
                }
            }
        }

        return $next($request);
    }

    /**
     * Check if the current route is authorized for the user's role.
     */
    private function isAuthorizedRoute(int $roleId, Request $request): bool
    {
        // Define role-based accessible routes
        $authorizedRoutes = [
            2 => ['dashboard', 'users.index', 'orders.index'], // Admin routes
            3 => ['welcome'],                                  // User routes
            4 => ['manager.home', 'manager.reports'],
        ];

        return isset($authorizedRoutes[$roleId]) &&
            $request->routeIs(...$authorizedRoutes[$roleId]);
    }
}
