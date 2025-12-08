<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Entities\Contact;

class GetContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        if ($request->getMethod() !== "GET") {
            return new Response(json_encode(["error" => "Method not allowed"]), 405, ["Content-Type" => "application/json"]);
        }

        $contacts = Contact::loadAll();

        return new Response(json_encode($contacts), 200, ["Content-Type" => "application/json"]);
    }
}
