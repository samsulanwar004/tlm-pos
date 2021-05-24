<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class PointOfSaleController extends Controller
{

    public function __construct(){
        $this->prefix = 'pos';
        $this->routePath = 'pos';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getUserActive();
        
        return view($this->prefix.'.index');
    }

    public function searchOrder($orderid)
    {
        $order = Order::where('id', $orderid)->where('status', 0)->first();

        if ($order) {
            $orders = OrderDetail::where('order_id', $order->id)->get();

            $result = [
                'order_id' => $order->id,
                'tenant_name' => $order->tenant->name,
                'number_reference' => $order->number_reference,
                'orders' => $orders->map(function($r) {
                    return [
                        'product_name' => $r->product_name,
                        'price' => $r->price,
                        'qty' => $r->qty,
                    ];
                })
            ];

            return $this->success('success', $result);
        } else {
            return $this->error('not found');
        }
    }

    public function processOrder(Request $request)
    {
        $value = $request->all();
        return $this->success('success', $value);
    }
}
