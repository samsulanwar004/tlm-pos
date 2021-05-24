<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getUserActive()
    {
        return auth()->user();
    }

    protected function success($msg = null, $data = null, $code = 200)
    {
    	return response()->json([
            'message' => $msg,
            'data' => $data
        ], $code);
    }

    protected function error($msg, $code = 500)
    {
    	return response()->json([
            'message' => $msg
        ], $code);
    }
}
