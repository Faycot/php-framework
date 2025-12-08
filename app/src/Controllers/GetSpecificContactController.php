<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Entities\Contact;

class GetSpecificContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        $uri = $request->getUri();
        $parts = explode('/contact/', $uri);

        if (!isset($parts[1]) || empty($parts[1])) {
            return new Response(
                json_encode(["error" => "No filename provided"]),
                400,
                ["Content-Type" => "application/json"]
            );
        }

        $filename = $parts[1];
        $path = __DIR__ . "/../../var/contacts/" . $filename;

        if (!file_exists($path)) {
            return new Response(
                json_encode(["error" => "Contact not found"]),
                404,
                ["Content-Type" => "application/json"]
            );
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if ($data === null) {
            return new Response(
                json_encode(["error" => "Invalid contact file"]),
                500,
                ["Content-Type" => "application/json"]
            );
        }

        $contact = Contact::fromArray($data);

        return new Response(
            json_encode($contact->toArray()),
            200,
            ["Content-Type" => "application/json"]
        );
    }
}