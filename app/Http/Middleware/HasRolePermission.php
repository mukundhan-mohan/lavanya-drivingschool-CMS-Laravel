<?php

namespace App\Http\Middleware;

use Closure;

class HasRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!in_array($role,  user_role_privileges())) {
            return abort(403);
        }
        
        
        return $next($request);
    }
}
