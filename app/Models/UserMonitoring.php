<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Use este
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserMonitoring extends Authenticatable // Mude para Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user_monitoring';
    protected $connection = 'mysql';

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

    protected $hidden = [
        'password', // Ocultar o campo de senha
        'remember_token',
    ];
}
