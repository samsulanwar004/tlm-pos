<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'master_order_details';
    protected $fillable = [
    	'master_order_id',
    	'order_id',
    	'price'
    ];

    public function masterOrder()
    {
        return $this->belongsTo('App\Models\MasterOrder', 'master_order_id', 'id');
    }
}
