<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Image;
use App\Models\Category;
use App\Models\PromotionDetail;
use App\Models\Review;
use App\Models\OrderDetail;

class Product extends Model
{
    use SoftDeletes;
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promotionDetail()
    {
        return $this->hasOne(PromotionDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
