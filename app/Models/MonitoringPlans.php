<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringPlans extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 
        'id_plant', 
        'temperatura',
        'umidade',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
