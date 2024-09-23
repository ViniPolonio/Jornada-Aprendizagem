<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plantas extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 
        'name_planta',
        'descrition',
        'image_one',
        'image_two',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
