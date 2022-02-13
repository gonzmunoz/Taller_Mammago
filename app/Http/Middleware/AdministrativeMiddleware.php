<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdministrativeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('userLogged')) {
            if (session('userLogged')['id_tipo_usuario'] == 1 || session('userLogged')['id_tipo_usuario'] == 2) {
                return $next($request);
            } else {
                return redirect('index');
            }
        } else {
            return redirect('index');
        }
    }
}
