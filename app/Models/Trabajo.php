<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    public $timestamps = false;
    protected $table = "trabajos";
    protected $guarded = [];
}
