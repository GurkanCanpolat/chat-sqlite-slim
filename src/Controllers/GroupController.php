<?php

namespace App\Controllers;

use App\Services\GroupService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GroupController {

    private GroupService $service;

    public function __construct(?GroupService $service = null) {
        $this->service = $service ?? new GroupService();
    }

    public function createGroup(Request $request, Response $response): Response {

        $data = $request->getParsedBody();
        $name = $data['name'];

        $groupId = $this->service->createGroup($name);

        $response->getBody()->write(json_encode([
            'status' => 'ok',
            'group_id' => $groupId
        ]));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function joinGroup(Request $request, Response $response, $args): Response {

        $groupId = $args['id'];
        $data = $request->getParsedBody();
        $userId = $data['user_id'];

        $this->service->joinGroup($groupId, $userId);

        $response->getBody()->write(json_encode(['status' => 'ok']));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
