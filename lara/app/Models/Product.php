<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id', 'country_id', 'overview', 'img', 'sale_id', 'count', 'price'];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
  
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
