<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Bootcamp_Coach extends Model
{
    protected $table = 'detalle_bootcamp_coach';
    //evitando los campos create_at / updated_at

    public $timestamps = false;
}
