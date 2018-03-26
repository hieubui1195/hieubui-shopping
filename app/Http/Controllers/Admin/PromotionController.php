<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Image;
use App\Models\PromotionDetail;
use Lang;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::allPromotions();

        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->getProdNotProm();

        return view('admin.promotions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionRequest $request)
    {
        $start = $this->createDate($request->promotionRage, 0, 19); 
        $end = $this->createDate($request->promotionRage, 21, 30);

        Promotion::create([
            'name' => $request->name,
            'start_date' => $start,
            'end_date' => $end,
        ]);

        $promotionId = Promotion::promotionId($request->name);

        // Images table
        $filename = $request->image->move(config('custom.image.path_promotion'), $request->image->getClientOriginalName());
        Image::create([
            'image' => $filename,
            'imageable_id' => $promotionId,
            'imageable_type' => config('custom.image.promotion'),
        ]);

        // Promotion Details table
        foreach ($request->products as $product) {
            PromotionDetail::create([
                'promotion_id' => $promotionId,
                'product_id' => $product,
                'percent' => $request->percent,
            ]);
        }

        return redirect()->route('admin.promotion.index')->with('msg', Lang::get('custom.msg.promotion_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            $promotionDetails = PromotionDetail::detailWithProduct($id);

            return view('admin.promotions.show', compact('promotion', 'promotionDetails'));
        } catch (ModelNotFoundException $e) {
            return view('admin.partials.404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            $products = $this->getProdEdit($id);
            $promotionDetails = Promotion::detailProduct($id)->pluck('product_id');
            $percent = config('custom.defaultZero');
            if (Promotion::detailProduct($id)->count() > 0) {
                $percent = Promotion::detailProduct($id)[0]['percent'];
            }
            $image = Promotion::promotionImage($id);

            return view('admin.promotions.edit', compact('promotion', 'products', 'promotionDetails', 'percent', 'image'));
        } catch (ModelNotFoundException $e) {
            return view('admin.partials.404');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PromotionRequest $request, $id)
    {
        $start = $this->createDate($request->promotionRage, 0, 19); 
        $end = $this->createDate($request->promotionRage, 21, 30);

        Promotion::find($id)->update([
            'name' => $request->name,
            'start_date' => $start,
            'end_date' => $end,
        ]);

        // Images table
        if ($request->image != null) {
            $filename = $request->image->move(config('custom.image.path_promotion'), $request->image->getClientOriginalName());
            Image::imageFirst($id, config('custom.image.promotion'))->update([
                'image' => $filename,
                'imageable_id' => $id,
                'imageable_type' => config('custom.image.promotion'),
            ]);
        }

        // Promotion Details table
        PromotionDetail::delDetail($id);
        foreach ($request->products as $product) {
            PromotionDetail::create([
                'promotion_id' => $id,
                'product_id' => $product,
                'percent' => $request->percent,
            ]);
        }

        return redirect()->route('admin.promotion.index')->with('msg', Lang::get('custom.msg.promotion_edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PromotionDetail::where('promotion_id', $id)->delete();
        Promotion::destroy($id);

        return redirect()->back()->with('msg', Lang::get('custom.msg.promotion_deleted'));
    }

    public function rejectItem(Request $request)
    {
        PromotionDetail::destroy($request->promotionDetailId);

        return response()->json(['msg' => Lang::get('custom.msg.promotion_item_rejected')]);
    }

    public function getProdNotProm()
    {
        $prodWithProm = PromotionDetail::all();
        $arrProdWithProm = [];
        foreach ($prodWithProm as $item) {
            array_push($arrProdWithProm, $item->product_id);
        }
        $productAll = Product::all();
        $products = [];
        foreach ($productAll as $product) {
            if (!in_array($product->id, $arrProdWithProm)) {
                $products[$product->id] = $product->name;
            }
        }

        return $products;
    }

    public function getProdEdit($id)
    {
        $products = $this->getProdNotProm();
        $promDetailProd = PromotionDetail::promDetailProd($id)->get();
        for ($i = 0; $i < count($promDetailProd); $i++) { 
            $productId = $promDetailProd[$i]['product']['id'];
            $productName = $promDetailProd[$i]['product']['name'];
            $products[$productId] = $productName;
        }

        return $products;
    }

    public function createDate($string, $start, $end)
    {
        $sub = substr((string) $string, $start, $end);
        $date = date('Y-m-d H:i:s', strtotime($sub));

        return $date;
    }
}
