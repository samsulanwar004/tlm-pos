<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DataStatic;
use App\Models\Order;
use App\Models\OrderDetail;
use Storage;

class UserController extends Controller
{

	public function __construct(DataStatic $static){
        $this->static = $static;
    }

    public function profile(Request $request)
    {   
        $user = $request->user();
        $user->status = $this->static->status()[$user->status];

        $words = explode(" ", $user->name);
        $initialUser = "";

        foreach ($words as $w) {
          $initialUser .= $w[0];
        }

        $user->initial_user = strtoupper($initialUser);

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

            if (isset($product['image']) && $product['image'] != null) {
                $filename = sprintf(
                    "%s-%s-%s.%s",
                    strtolower(str_replace(' ', '', $user->username)),
                    strtolower(str_replace(' ', '', $product['product_name'])),
                    date('Ymdhis'),
                    'jpg'
                );

                //upload file
                Storage::disk('public')->put('/upload/product/'.$filename, base64Image($product['image']));

                $product['image'] = $filename;
            }

    		OrderDetail::create([
	    		'order_id' => $order->id,
	    		'product_name' => $product['product_name'],
	    		'price'  => $product['price'],
	    		'qty'  => $product['qty'],
                'image'  => $product['image'],
	    	]);
    	}

    	return $this->success('success', $order);
    }

    public function history(Request $request)
    {

        $value = $request->all();

        $user = $request->user();

        $orders = Order::where('tenant_id', $user->id)
            ->take(isset($value['limit']) ? $value['limit'] : 100)
            ->skip(isset($value['offset']) ? $value['offset'] : 0)
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($orders as $key => $order) {
            $orders[$key]->status = $this->static->status_order()[$order->status];
            $orders[$key]->order_details = OrderDetail::where('order_id', $order->id)->select('product_name', 'qty', 'price')->get();
        }

        return $this->success('success', $orders);
    }
}
