<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Map role aliases
        $roleMap = [
            'buyer' => 'pembeli',
            'seller' => 'penjual'
        ];
        
        // Convert expected roles using the map
        $mappedRoles = array_map(function($role) use ($roleMap) {
            return $roleMap[$role] ?? $role;
        }, $roles);
        
        if (!in_array($user->role, $mappedRoles)) {
            // Jika pembeli mencoba akses admin area, redirect ke home
            if ($user->isPembeli()) {
                return redirect()->route('front.index')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            // Jika penjual mencoba akses buyer area, redirect ke admin dashboard
            if ($user->isPenjual()) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            
            // Untuk kasus lain, tampilkan 403
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
