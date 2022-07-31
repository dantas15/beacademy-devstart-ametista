<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
   
    protected $table = 'products';
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'amount', 'cost_price', 'sale_price', 'main_photo'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
