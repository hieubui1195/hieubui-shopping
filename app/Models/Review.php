<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\User;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'user_id',
        'title',
        'content',
        'rate',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeReviewProduct($query, $productId)
    {
        return $query->where('product_id', $productId)
                    ->with('user')
                    ->orderBy('created_at')
                    ->get();
    }

    public function scopeReviewLimit($query, $productId)
    {
        return $query->where('product_id', $productId)
                    ->where('deleted_at', null)
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->take(config('custom.default_limit'))
                    ->get();
    }

    public function scopeLoadMore($query, $id, $productId)
    {
        return $query->where('product_id', $productId)
                    ->where('id', '<', $id)
                    ->orderBy('created_at', 'desc')
                    ->limit(config('custom.default_limit'))
                    ->get();
    }

    public function scopeReviewExist($query, $productId, $userId)
    {
        return $query->where('product_id', $productId)->where('user_id', $userId);
    }

    public function scopeGetReview($query, $id)
    {
        return $query->where('id', $id)->get();
    }

    public function scopeReviewFind($query, $id)
    {
        return $query->find($id);
    }

    public function scopeReviewUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
