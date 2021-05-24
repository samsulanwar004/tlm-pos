<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\MasterOrder;
use App\Models\MasterOrderDetail;

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

        $user = $request->user();

        $status = 0;
        if ($value['type'] == 0 || $value['type'] == 1) {
            $status = 1;

            Order::whereIn('id', $value['orders'])->update(['status' => $status]);
        }

        $order = MasterOrder::create([
            'type_payment' => $value['type'],
            'status' => $status,
            'number_reference' => date('Ymdhis'),
            'created_by' => $user->id
        ]);

        foreach ($value['orders'] as $orderid) {
            MasterOrderDetail::create([
                'master_order_id' => $order->id,
                'order_id' => $orderid
            ]);
        }

        return $this->success('success', $order);
    }
}
