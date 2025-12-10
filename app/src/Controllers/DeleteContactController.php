<?php

namespace App\Controllers;

use App\Lib\Controllers\AbstractController;
use App\Lib\Http\Request;
use App\Lib\Http\Response;
use App\Managers\ContactManager;

class DeleteContactController extends AbstractController {

    public function process(Request $request): Response {

        if ($request->getMethod() !== 'DELETE') {
            return new Response(
                json_encode(['error' => 'Method not allowed']),
                405,
                ['Content-Type' => 'application/json']
            );
        }

        $uriCut = explode('/', trim($request->getUri(), '/'));

        if (!isset($uriCut[1])) {
            return new Response(
                json_encode(['error' => 'no filename provided']),
                400,
                ['Content-Type' => 'application/json']
            );
        }

        $filename = $uriCut[1];

        $manager = new ContactManager();
        $contactData = $manager->getContact($filename);

        if (!$contactData) {
            return new Response(
                json_encode(['error' => 'File not found']),
                404,
                ['Content-Type' => 'application/json']
            );
        }

        $delete = $manager->deleteContact($filename);

        if ($delete) {
            return new Response(
                json_encode(['message' => 'File deleted successfully']),
                204,
                ['Content-Type' => 'application/json']
            );
        }

        return new Response(
            json_encode(['error' => 'Failed to delete file']),
            404,
            ['Content-Type' => 'application/json']
        );
    }
}