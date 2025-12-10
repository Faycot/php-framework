<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

class TestController extends AbstractController {


    public function process(Request $request): Response {
        return new Response(
            json_encode(["message" => "Test Controller"]),
            200,
            ["Content-Type" => "application/json"]
        );
    }
}