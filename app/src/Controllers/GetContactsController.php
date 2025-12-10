<?php
namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Managers\ContactManager;

class GetContactsController extends AbstractController {

    public function process(Request $request): Response {
        if ($request->getMethod() !== "GET") {
            return new Response(
                json_encode(['error' => 'Method not allowed']),
                405,
                ['Content-Type' => 'application/json']
            );
        }

        $contactManager = new ContactManager();
        $contacts = $contactManager->getAllContacts();

        return new Response(json_encode($contacts, JSON_PRETTY_PRINT), 200, ['Content-Type' => 'application/json']);
    }
}