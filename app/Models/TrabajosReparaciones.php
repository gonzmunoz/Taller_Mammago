<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajosReparaciones extends Model
{
    public $timestamps = false;
    protected $table = "trabajos_reparaciones";
    protected $guarded = [];
}
