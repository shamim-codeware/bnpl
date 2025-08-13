<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\MenuPermission;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $current_path = $request->path();
        $explode_path = explode('/', $current_path)[0];
        $permission   = MenuPermission::where('role_id', Auth::user()->role_id)
                            ->whereHas('menu', function ($q) use ($explode_path){
                                $q->where('url', $explode_path);
                            })->exists();

        if (!$permission) {
            return response('Access Denied: This URL is not allowed', 403);
        }

        return $next($request); 
    }
}
