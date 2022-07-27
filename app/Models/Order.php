<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    use HasFactory;

    protected $fillable = ['name', 'description', 'amount', 'cost_price', 'sale_price', 'main_photo'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
