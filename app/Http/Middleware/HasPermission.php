<?php

namespace App\Http\Middleware;

use Closure;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menu)
    {
        if($menu == "permissions") {
            if(!auth()->user()->isAdmin) {
                return abort(403);
            }
        }else {
            if(!in_array($menu,  user_menu_privileges())) {
                return abort(403);
            }
        }
        
        
        return $next($request);
    }
}
