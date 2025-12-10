<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Managers\ContactManager;

class GetSpecificContactController extends AbstractController{

    public function process(Request $request): Response {
        $uriCut = explode('/', trim($request->getUri(),'/'));
        $filename = $uriCut[1];
        if ($request->getMethod() !== 'GET') {
            return new Response(
                json_encode(['error' => 'Method not allowed']),
                405,
                ['Content-Type' => 'application/json']
            );
        }

        $contactManager = new ContactManager();
        $contact = $contactManager->getContact($filename);

        if (!$contact) {
            return new Response(
                json_encode(['error' => 'File not found']),
                404,
                ['Content-Type' => 'application/json']
            );
        }

        return new Response(json_encode($contact, JSON_PRETTY_PRINT), 200, ['Content-Type' => 'application/json']);
    }
}