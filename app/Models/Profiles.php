<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use Illuminate\Foundation\Auth\Profiles as Authenticatable;

class Profiles extends Model
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
