<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
    	'tenant_id',
    	'number_reference',
    	'status',
        'total'
    ];

    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'id');
    }

    public function tenant()
    {
        return $this->belongsTo('App\Models\Tenant', 'tenant_id', 'id');
    }
}
