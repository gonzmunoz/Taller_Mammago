<?php

function assetFtp($path)
{
    return asset('http://www.iestrassierra.net/alumnado/curso1920/DAW/daw1920a11/Proyecto/Mammago/laravel/public/' . $path);
    // return 'http://www.iestrassierra.net/alumnado/curso1920/DAW/daw1920a11/laravel/public';
}

function getRol($nombre_usuario)
{
    $rol = \App\Models\Usuario::where('nombre_usuario', '=', $nombre_usuario)->first();
    return $rol;
}


