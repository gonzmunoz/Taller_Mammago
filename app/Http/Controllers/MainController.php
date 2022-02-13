<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use App\Models\Reparacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        // DEVUELVO LA VISTA PRINCIPAL DE LA TIENDA

        $_data['clients'] = count(Usuario::where('id_tipo_usuario', 4)->get()->toArray());
        $_data['repairs'] = count(Reparacion::all());
        $_data['sales'] = count(Pedidos::all());
        return view('layout.index', $_data);
    }

}
