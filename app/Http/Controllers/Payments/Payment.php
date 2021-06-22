<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Payment extends Controller
{

    public function checkUser(Request $request)
    {
        try {

            return response()->json(
                [
                    'status' => 0,
                    "message" => "Test",
                ]
            );
        } catch (\Exception $e) {

        }
    }
}
