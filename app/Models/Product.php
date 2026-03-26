<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image', // если ещё оставил старое поле
    ];

    // Отношение к изображениям — ВНУТРИ КЛАССА!
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Опционально — главное изображение
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
}