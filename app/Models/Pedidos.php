<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    public $timestamps = false;
    protected $table = "pedidos";
    protected $guarded = [];
}
