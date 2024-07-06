<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['login', 'password', 'name', 'address', 'email', 'phone'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
