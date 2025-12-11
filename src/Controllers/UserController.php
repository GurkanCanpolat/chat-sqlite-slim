<?php

namespace App\Controllers;

use App\Services\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController {

    private UserService $service;

    public function __construct(?UserService $service = null) {
        $this->service = $service ?? new UserService();
    }

    public function createUser(Request $request, Response $response): Response {

        $data = $request->getParsedBody();
        $username = $data['username'];

        $userId = $this->service->createUser($username);

        $response->getBody()->write(json_encode([
            'status' => 'ok',
            'user_id' => $userId
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getAllUsers(Request $request, Response $response): Response {
        $users = $this->service->getAllUsers();
        $response->getBody()->write(json_encode($users, JSON_PRETTY_PRINT));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
