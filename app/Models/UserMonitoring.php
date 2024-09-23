<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserMonitoring extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id', 
        'name', 
        'email', 
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];
}
