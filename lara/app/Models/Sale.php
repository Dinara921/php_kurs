<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'discount', 'expired_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
