<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    public $timestamps = false;
    protected $table = "reparaciones";
    protected $guarded = [];
}
