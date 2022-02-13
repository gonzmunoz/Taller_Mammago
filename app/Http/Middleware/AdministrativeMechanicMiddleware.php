<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdministrativeMechanicMiddleware
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
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                return redirect('index');
            } else {
                return $next($request);
            }
        } else {
            return redirect('index');
        }
    }
}
