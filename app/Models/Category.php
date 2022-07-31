<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes,
};

class Category extends Model
{
    protected $table = 'categories';
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
}
