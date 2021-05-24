<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DataStatic;
use App\Models\Order;
use App\Models\OrderDetail;

class UserController extends Controller
{

	public function __construct(DataStatic $static){
        $this->static = $static;
    }

    public function profile(Request $request)
    {   
        $user = $request->user();
        $user->status = $this->static->status()[$user->status];

        return $this->success('success', $user);
    }

    public function order(Request $request)
    {

    	$request->validate([
            'orders' => 'required|array',
            'orders.*.product_name' => 'required|string',
            'orders.*.price' => 'required|numeric',
            'orders.*.qty' => 'required|numeric',
        ]);

        $value = $request->all();

    	$user = $request->user();

    	$order = Order::create([
    		'tenant_id' => $user->id,
    		'number_reference' => date('Ymdhis')
    	]);

    	foreach ($value['orders'] as $product) {
    		OrderDetail::create([
	    		'order_id' => $order->id,
	    		'product_name' => $product['product_name'],
	    		'price'  => $product['price'],
	    		'qty'  => $product['qty'],
	    	]);
    	}

    	return $this->success('success', $order);
    }
}
