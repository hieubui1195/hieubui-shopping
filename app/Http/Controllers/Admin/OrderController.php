<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\OrderSuccessMail;
use App\Mail\OrderRejectMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use DateTime;
use Lang;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::allOrders();

        return view('admin.orders.index', compact('orders'));
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
            $order = Order::findOrFail($id);
            $orderDetails = OrderDetail::detailWithProduct($id);
            $promotions = [];
            foreach ($orderDetails as $orderDetail) {
                $promotion = Product::find($orderDetail->product_id)->promotionDetail;
                if ($promotion) {
                    array_push($promotions, $promotion->percent);
                } else {
                    array_push($promotions, config('custom.defaultZero'));
                }
            }
            
            return view('admin.orders.show', compact('order', 'orderDetails', 'promotions'));
            
        } catch (ModelNotFoundException $e) {
            return view('admin.partials.404');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        Mail::to($order->email)->send(new OrderRejectMail($id));
        $orderDetails = OrderDetail::orderDetail($id)->delete();
        Order::find($id)->update([
            'state' => config('custom.defaultTwo')
        ]);
        $order->delete();
        
        return response()->json(['msg' => Lang::get('custom.msg.order_rejected')]);
    }

    public function approveOrder(Request $request)
    {
        Order::find($request->orderId)->update([
            'deliver_date' => new DateTime,
            'state' => config('custom.defaultOne'),
        ]);
        
        // Update products table
        $orderDetails = OrderDetail::orderDetail($request->orderId)->get();
        foreach ($orderDetails as $orderDetail) {
            $amountCurrent = Product::find($orderDetail->product_id)->value('amount');
            $amountNew = $amountCurrent - $orderDetail->amount;
            Product::find($orderDetail->product_id)->update([
                'amount' => $amountNew,
            ]);
        }
        $orderEmail = Order::orderFind($request->orderId)->value('email');
        Mail::to($orderEmail)->send(new OrderSuccessMail($request->orderId));
                    
        return response()->json(['msg' => Lang::get('custom.msg.order_approved')]);
    }
}
