<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;

abstract class AbstractController{
    abstract public function process(Request $request): Response;
}