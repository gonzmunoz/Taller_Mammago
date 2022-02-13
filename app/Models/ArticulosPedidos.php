<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosPedidos extends Model
{
    public $timestamps = false;
    protected $table = "articulos_pedidos";
    protected $guarded = [];
}
