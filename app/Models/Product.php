<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'name',
        'image',
        'SKU',
        'category',
    ];

    protected $casts = [
    'notes' => 'array',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
