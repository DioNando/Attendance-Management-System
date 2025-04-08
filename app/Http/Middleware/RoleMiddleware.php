<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $userRole = Auth::user()?->role->value;
        if ($userRole !== $role) {
            abort(403, 'Accès non autorisé.');
        }
        return $next($request);
    }
}
