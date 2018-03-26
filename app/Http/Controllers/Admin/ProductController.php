<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\Review;
use Lang;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::allProductsWithImagesCategory();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories  = Category::subCategories();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'amount' => $request->amount,
        ]);
        
        $productId = Product::productId($request->name);
        foreach ($request->images as $image) {
            $filename = $image->move(config('custom.image.path_product'), $image->getClientOriginalName());
            Image::create([
                'image' => $filename,
                'imageable_id' => $productId,
                'imageable_type' => config('custom.image.product'),
            ]);
        }

        return redirect()->route('admin.product.index')->with('msg', Lang::get('custom.msg.product_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $images = Product::productImages($id);
        $arrImg = [];
        for ($i = 0; $i < count($images[0]['images']); $i++) { 
            $images[0]['images'][$i]['image'];
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

        return view('admin.products.show', compact('product', 'arrImg', 'promotion', 'reviews', 'countVote', 'avgVote'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::withTrashed()
                            ->productImages($id);
        $categories = Category::subCategories();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        Product::find($id)->update([
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'amount' => $request->amount,
        ]);

        if ($request->images != null) {
            $imgInits = Image::delImagesProduct($id);

            foreach ($request->images as $image) {
                $filename = $image->move(config('custom.image.path_product'), $image->getClientOriginalName());
                Image::create([
                    'image' => $filename,
                    'imageable_id' => $id,
                    'imageable_type' => config('custom.image.product'),
                ]);
            }
        }

        return redirect()->route('admin.product.index')->with('msg', Lang::get('custom.msg.product_edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);

        return redirect()->back()->with('msg', Lang::get('custom.msg.product_deleted'));
    }

    public function reuse(Request $request)
    {
        Product::productRestore($request->name);

        return response()->json(['statusReuse' => config('custom.defaultOne'), 'msg' => Lang::get('custom.msg.reuse_success')]);
    }
    
}
