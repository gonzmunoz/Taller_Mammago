<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    public $timestamps = false;
    protected $table = "citas";
    protected $guarded = [];
}
