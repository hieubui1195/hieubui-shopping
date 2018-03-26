<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Models\PromotionDetail;
use App\Models\Image;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use Session;
use Auth;
use Cart;

class HomeController extends Controller
{
    public function getProd(Request $request, $id)
    {
        $product = Product::find($id);
        $images = Product::productImages($id);
        $arrImg = [];
        for ($i = 0; $i < count($images[0]['images']); $i++) { 
            array_push($arrImg, $images[0]['images'][$i]['image']);
        } 

        $promotion = 0;
        if (Product::find($id)->promotionDetail) {
            $promotion = Product::find($id)->promotionDetail;
        }

        $reviews = Review::reviewProduct($id);
        $countVote = count($reviews);
        $totalVote = 0;
        $avgVote = 0;
        if (count($reviews) > 0) {
            $votes = $reviews->pluck('rate');
            foreach ($votes as $vote) {
                $totalVote += $vote;
            }
            $avgVote = floor($totalVote / count($votes));
        }

        $reviewLimits = Review::reviewLimit($id);
        if ($request->ajax()) {
            return view('user.partials.review', compact('review', 'reviewLimits'));
        }

        return view('user.layouts.product-details', compact('product', 'arrImg', 'promotion', 'reviews', 'countVote', 'avgVote', 'reviewLimits'));     
    }

    public function checkReview(Request $request)
    {
        $existed = false;
        $count = Review::reviewExist($request->productId, $request->userId)->count();
        if ($count > 0) {
            $existed = true;
        }

        return response()->json(['status' => $existed]);
    }

    public function sendReview(Request $request)
    {
        Review::create([
            'product_id' => $request->productId,
            'user_id' => $request->userId,
            'title' => $request->title,
            'content' => $request->content,
            'rate' => $request->rate,
        ]);

        $reviewLimits = Review::reviewLimit($request->productId);

        return view('user.partials.review', compact('reviewLimits'));
    }

    public function getReview(Request $request)
    {
        $review = Review::getReview($request->id);

        return response()->json([
            'productId' => $review[0]['product_id'],
            'title' => $review[0]['title'],
            'content' => $review[0]['content'],
            'rate' => $review[0]['rate'],
        ]);
    }

    public function editReview(Request $request)
    {
        Review::reviewFind($request->id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'rate' => $request->rate,
        ]);

        $reviewLimits = Review::reviewLimit($request->productId);
        
        if (!$reviewLimits->isEmpty()) {
            return view('user.partials.review', compact('reviewLimits'));
        }
    }

    public function deleteReview(Request $request, $id)
    {
        if ($request->ajax()) {
            Review::destroy($request->id);
            $reviewLimits = Review::reviewLimit($request->productId);

            return view('user.partials.review', compact('reviewLimits'));
        }
    }
    
    public function loadReviewAjax(Request $request)
    {
        $reviewLimits = Review::loadMore($request->id, $request->productId);
        
        if (!$reviewLimits->isEmpty()) {
            return view('user.partials.review', compact('reviewLimits'));
        }
    }

    public function checkQty(Request $request)
    {
        $status = true;
        $product = Product::productFind($request->id);
        if ($request->qtyCompare > $product->amount) {
            $status = false;
        }

        return response()->json([
            'status' => $status,
            'qty' => $product->amount,
        ]);
    }

    public function getHome()
    {
        $images = Image::imageType(config('custom.image.promotion'))->get();
        $lastest_products = Product::orderTake()->get();
        $promotion_products = PromotionDetail::orderTake()->get();

        return view('user.layouts.index',[
            'images' => $images,
            'lastest_products' => $lastest_products,
            'promotion_products' => $promotion_products,
        ]);
    }

    public function getSearch(Request $request)
    {
        $search = $request->input('search');
        if ($request->type) {
            switch ($request->type) {
                case config('custom.defaultZero'):
                case config('custom.defaultOne'):
                    $products = Product::search($search, 'price', 'asc');
                    break;
                
                case config('custom.defaultTwo'):
                    $products = Product::search($search, 'price', 'desc');
                    break;
            }
        } else {
            $products = Product::search($search, 'price', 'asc');
        }

        return view('user.layouts.search', compact('products', 'search'));
    }

    public function getCategory(Request $request, $type)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case config('custom.defaultZero'):
                case config('custom.defaultOne'):
                    $product_in_cates = Product::orderCategory($type, 'price', 'asc');
                    break;
                
                case config('custom.defaultTwo'):
                    $product_in_cates = Product::orderCategory($type, 'price', 'desc');
                    break;
            }
        } else {
            $product_in_cates = Product::orderCategory($type, 'price', 'asc');
        }

        return view('user.layouts.products', compact('product_in_cates'));
    }

    public function getLatestProduct(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case config('custom.defaultOne'):
                    $latest_products_all = Product::orderPaginate('price', 'asc');
                    break;
                case config('custom.defaultZero'):
                case config('custom.defaultTwo'):
                    $latest_products_all = Product::orderPaginate('price', 'desc');
                    break;
            }

        } else {
            $latest_products_all = Product::orderPaginate('id', 'desc');
        }

        return view('user.layouts.latestproducts', compact('latest_products_all'));
    }

    public function getPromotionProduct(Request $request)
    {
        if ($request->ajax()) {
            switch ($request->type) {
                case config('custom.defaultOne'):
                    $promotion_products_all = PromotionDetail::orderPaginate('percent', 'asc');
                    break;
                case config('custom.defaultZero'):
                case config('custom.defaultTwo'):
                    $promotion_products_all = PromotionDetail::orderPaginate('percent', 'desc');
                    break;
            }

        } else {
            $promotion_products_all = PromotionDetail::orderPaginate('percent', 'desc');
        }
        
        return view('user.layouts.promotionproducts', compact('promotion_products_all'));
    }

    public function getInformation($id)
    {
        
        $user = User::find($id);
        $orders = Order::withOrderDetail($user->email)->get();

        return view('user.layouts.info',compact('user', 'orders'));
    }

    public function getUserUpdate(UserRequest $request, $id)
    {
        User::find($id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        if ($request->password != null) {
            User::find($id)->update([
                'password' => bcrypt($request->password),
            ]);
        }

        if ($request->avatar != null) {
            $filename = $request->avatar->move(config('custom.image.path_avatar'), $request->avatar->getClientOriginalName());
            $image = Image::imageFirst($id, config('custom.image.user'))->update([
                'image' => $filename,
                'imageable_id' => $id,
                'imageable_type' => config('custom.image.user'),
            ]);
        }

        return redirect()->back();
    }
}
