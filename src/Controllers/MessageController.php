<?php

namespace App\Controllers;

use App\Services\MessageService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class MessageController {

    private MessageService $service;

    public function __construct(?MessageService $service = null) {
        $this->service = $service ?? new MessageService();
    }

    public function sendMessage(Request $request, Response $response, $args): Response {

        $groupId = $args['id'];
        $data = $request->getParsedBody();

        $userId = $data['user_id'];
        $message = $data['message'];

        $msg = $this->service->sendMessage($groupId, (string)$userId, $message);

        $response->getBody()->write(json_encode($msg));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getMessages(Request $request, Response $response, $args): Response {

        $groupId = $args['id'];

        $messages = $this->service->getMessages($groupId);

        $response->getBody()->write(json_encode($messages));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
