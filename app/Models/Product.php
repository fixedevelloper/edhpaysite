<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
        'description',
        'price',
        'image',
        'sale_price',
        'slug',
        'quatity',
        'categorie_id',
        'shop_id'
    ];
    public function categorie() {
        return $this->belongsTo(Categorie::class, 'categorie_id', 'id');
    }
    public function shop() {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }
    public function images() {
        return $this->belongsToMany(Image::class,'image_products');
    }
    public function scopeFeatures($query)
    {
        return $query->where('user_type', '=', 1)->where(['activate'=>true]);
    }
}
