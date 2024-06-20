<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id', 'country_id', 'img', 'sale_id', 'count', 'price'];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
  
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class);
    }

    public function country()
    {
        return $this->belongsTo(CountryProduct::class);
    }
    
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
