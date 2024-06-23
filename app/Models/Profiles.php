<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Profiles extends Authenticatable
{
    
    use HasFactory;
    protected $table="Profiles";
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'image',
        'attached',
    ];

}
