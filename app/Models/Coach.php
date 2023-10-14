<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $table = 'coach';
    //evitando los campos create_at / updated_at

    public $timestamps = false;
}
