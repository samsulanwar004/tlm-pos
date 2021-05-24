<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterOrder extends Model
{
    use HasFactory;

    protected $table = 'master_orders';
    protected $fillable = [
    	'number_reference',
    	'status',
    	'type_payment',
        'json_response',
        'created_by',
        'modify_by',
    ];

    public function masterOrderDetail()
    {
        return $this->hasMany('App\Models\MasterOrderDetail', 'master_order_id', 'id');
    }
}
