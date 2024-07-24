<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'password', 'name', 'address', 'phone', 'token'];

    public function orders()  
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()  
    {
        return $this->hasMany(Review::class);
    }

}
