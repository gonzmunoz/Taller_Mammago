<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorizacion extends Model
{
    public $timestamps = false;
    protected $table = "motorizaciones_coche";
    protected $guarded = [];
}
