<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Xplayer extends Model
{
    use HasFactory;

    protected $table = 'x_player';

    protected $fillable = [
    	'user_id',
    	'player_id',
    ];
}
