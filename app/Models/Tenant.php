<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tenant extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'tenants';

    protected $fillable = [
        'username',
        'password',
        'api_token',
        'name',
        'status',
        'created_by',
        'modify_by',
    ];

    protected $hidden = [
        'api_token',
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        if($value != ""){
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
