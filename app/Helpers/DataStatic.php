<?php

namespace App\Helpers;

class DataStatic
{

    public static function status(){
        return array(
            1 =>'Active',
            0 =>'Inactive',
        );
    }

    public static function status_order(){
        return array(
            0 =>'Process',
            1 =>'Success',
            2 =>'Cancel',
        );
    }

    public static function type_payment(){
        return array(
            0 =>'Cash',
            1 =>'EDC',
        );
    }
}
