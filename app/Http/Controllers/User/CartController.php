<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\OrderRequest;
use App\Jobs\OrderSuccessJob;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\App;
use Lang;
use Cart;
use PDF;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $productId = $request->productId;
        $product = Product::productImageFirst($productId);
        $image = $product['images'][0]['image'];
        Cart::add([
            'id' => $productId,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $request->price,
            'options' => [
                'image' => $image,
                'intPrice' => $product->price,
                'intQty' => $product->amount,
            ]
        ]);
        $cart = Cart::content();

        return view('user.partials.cart-list', compact('cart'));
    }

    public function removeItem(Request $request)
    {
        Cart::remove($request->rowId);
        $cart = Cart::content();

        return view('user.partials.cart-list', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        Cart::update($request->rowId, $request->qty);
        $cart = Cart::content();

        return response()->json($cart);
    }

    public function getCheckout()
    {
        $cart = Cart::content();
        
        return view('user.layouts.checkout', compact('cart'));
    }

    public function checkout(Request $request)
    {
        $orderCheck = Order::orderCheck($request->email);
        if ($orderCheck->count() == config('custom.defaultZero')) {
            $order = Order::create([
                'email' => $request->email,
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'purchase_date' => Carbon::now(),
                'state' => config('custom.defaultZero'),
            ]);
            $orderId = $order->id;
        } else {
            $orderCheck->update([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'purchase_date' => Carbon::now(),
            ]);
            $orderId = $orderCheck->get()[0]['id'];
            OrderDetail::where('order_id', $orderId)->delete();
        }

        $cart = Cart::content();
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $orderId,
                'product_id' => $item->id,
                'amount' => $item->qty,
            ]);
        }
        $order = Order::find($orderId);

        return view('user.partials.noty-order', compact('cart', 'order'));
    }

    public function pdfview(Request $request)
    {
        $cart = Cart::content();
        if($request->has('download')){
            $pdf = PDF::loadView('user.partials.noty-order', compact('cart'));
            return $pdf->download('order.pdf');
        }

        return view('user.partials.noty-order');
    }
}
