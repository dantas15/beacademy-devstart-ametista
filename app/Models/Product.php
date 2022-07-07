<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    use HasFactory;

    protected $fillable = ['name', 'description', 'amount', 'cost_price', 'sale_price', 'main_photo'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

}
