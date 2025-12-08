<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Entities\Contact;

class PostContactController extends AbstractController
{
    public function process(Request $request): Response
    {
        if ($request->getMethod() !== "POST") {
            return new Response(json_encode(["error" => "Method not allowed"]), 405, ["Content-Type" => "application/json"]);
        }

        $headers = $request->getHeaders();
        if (($headers["Content-Type"] ?? null) !== "application/json") {
            return new Response(json_encode(["error" => "Invalid content type"]), 400, ["Content-Type" => "application/json"]);
        }

        $raw = file_get_contents("php://input");
        $data = json_decode($raw, true);
        if (!$data) {
            return new Response(json_encode(["error" => "Invalid JSON"]), 400, ["Content-Type" => "application/json"]);
        }

        $allowed = ["email", "subject", "message"];
        foreach ($data as $key => $value) {
            if (!in_array($key, $allowed)) {
                return new Response(json_encode(["error" => "Invalid property: $key"]), 400, ["Content-Type" => "application/json"]);
            }
        }

        if (!isset($data["email"], $data["subject"], $data["message"])) {
            return new Response(json_encode(["error" => "Missing required fields"]), 400, ["Content-Type" => "application/json"]);
        }

        $timestamp = time();

        $contact = new Contact(
            $data["email"],
            $data["subject"],
            $data["message"],
            $timestamp,
            $timestamp
        );

        $filename = $timestamp . "_" . $contact->getEmail() . ".json";
        $path = __DIR__ . "/../../var/contacts/" . $filename;

        file_put_contents($path, json_encode($contact->toArray(), JSON_PRETTY_PRINT));

        return new Response(json_encode(["file" => $filename]), 201, ["Content-Type" => "application/json"]);
    }
}