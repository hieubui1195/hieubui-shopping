<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Promotion;
use App\Models\Product; 

class PromotionDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'promotion_id',
        'product_id',
        'amount',
        'percent',
    ];

    public function promotion()
    {
        $this->belongsTo(Promotion::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeDetailWithProduct($query, $id)
    {
        return $query->where('promotion_id', $id)->with('product')->get();
    }

    public function scopeDelDetail($query, $promotionId)
    {
        return $query->where('promotion_id', $promotionId)->delete();
    }

    public function scopeOrderPaginate($query, $type, $sort)
    {
        return $query->orderBy($type, $sort)->paginate(config('custom.defaultEight'));
    }

    public function scopeOrderTake($query)
    {
        return $query->orderBy('percent', 'desc')
                        ->take(config('custom.defaultEight'));
    }

    public function scopePromDetailProd($query, $promotionId)
    {
        return $query->where('promotion_id', $promotionId)->with('product');
    }
}
