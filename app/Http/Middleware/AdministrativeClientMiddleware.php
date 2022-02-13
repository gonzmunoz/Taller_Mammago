<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdministrativeClientMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('userLogged')) {
            if (session('userLogged')['id_tipo_usuario'] == 3) {
                return redirect('index');
            } else {
                return $next($request);
            }
        } else {
            return redirect('index');
        }
    }
}
