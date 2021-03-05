<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public function apiResponse($success, $message, $data = null, $code = 200)
    {
        return response()->json(['success' => success, 'message' => $message, 'data' => $data, 'code' => $code]);
    }
}
