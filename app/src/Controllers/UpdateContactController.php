<?php

namespace App\Controllers;

use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Managers\ContactManager;

class UpdateContactController extends AbstractController {

    public function process(Request $request): Response {
        $uriCut = explode('/', trim($request->getUri(),'/'));
        $filename = $uriCut[1];

        if ($request->getMethod() !== 'PATCH') {
            return new Response(
                json_encode(['error' => 'Method not allowed']),
                405,
                ['Content-Type' => 'application/json']
            );
        }

        $contactManager = new ContactManager();

        $contactData = $contactManager->getContact($filename);

        if(!$contactData){
            return new Response(
                json_encode(['error' => 'File not found']),
                404,
                ['Content-Type' => 'application/json']
            );
        }

        $body =json_decode(file_get_contents('php://input'), true);
        $validation = $contactManager->validate($body, ['email', 'subject', 'message']);

        if ($validation !== null) {
            return $validation;
        }

        $updateContact = $contactManager->updateContact($filename, $body);

        return new Response(json_encode($updateContact, JSON_PRETTY_PRINT),200, ['Content-Type' => 'application/json']);
    }
}