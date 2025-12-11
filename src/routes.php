<?php

use Slim\App;
use App\Controllers\GroupController;
use App\Controllers\MessageController;
use App\Controllers\UserController;

return function (App $app): void {

    // root for smoke test
    $app->get('/', function ($req, $res) {
        $res->getBody()->write('bunq-chat OK');
        return $res;
    });

    // Users
    $app->get('/getAllUsers', [UserController::class, 'getAllUsers']);
    $app->post('/users', [UserController::class, 'createUser']);

    // Groups
    $app->post('/groups', [GroupController::class, 'createGroup']);
    $app->post('/groups/{id}/join', [GroupController::class, 'joinGroup']);

    // Messages
    $app->post('/groups/{id}/messages', [MessageController::class, 'sendMessage']);
    $app->get('/groups/{id}/messages', [MessageController::class, 'getMessages']);

        // OpenAPI / Swagger
        $app->get('/openapi.json', function ($req, $res) {
            $spec = [
                'openapi' => '3.0.0',
                'info' => [
                    'title' => 'bunq-chat API',
                    'version' => '1.0.0',
                    'description' => 'Minimal chat API: users, groups, join group, messages'
                ],
                'paths' => [
                    '/' => [
                        'get' => [
                            'summary' => 'Smoke test',
                            'responses' => [
                                '200' => ['description' => 'OK']
                            ]
                        ]
                    ],
                    '/users' => [
                        'post' => [
                            'summary' => 'Create a user',
                            'requestBody' => [
                                'required' => true,
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'username' => ['type' => 'string']
                                            ],
                                            'required' => ['username']
                                        ]
                                    ]
                                ]
                            ],
                            'responses' => [
                                '200' => ['description' => 'User created']
                            ]
                        ]
                    ],
                    '/getAllUsers' => [
                        'get' => [
                            'summary' => 'Get all users',
                            'responses' => [
                                '200' => [
                                    'description' => 'Array of users',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'object',
                                                    'properties' => [
                                                        'id' => ['type' => 'string'],
                                                        'username' => ['type' => 'string']
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    '/groups' => [
                        'post' => [
                            'summary' => 'Create a group',
                            'requestBody' => [
                                'required' => true,
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'name' => ['type' => 'string']
                                            ],
                                            'required' => ['name']
                                        ]
                                    ]
                                ]
                            ],
                            'responses' => [
                                '200' => ['description' => 'Group created']
                            ]
                        ]
                    ],
                    '/groups/{id}/join' => [
                        'post' => [
                            'summary' => 'Join a group',
                            'parameters' => [
                                ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]
                            ],
                            'requestBody' => [
                                'required' => true,
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'user_id' => ['type' => 'string']
                                            ],
                                            'required' => ['user_id']
                                        ]
                                    ]
                                ]
                            ],
                            'responses' => [
                                '200' => ['description' => 'Joined group']
                            ]
                        ]
                    ],
                    '/groups/{id}/messages' => [
                        'post' => [
                            'summary' => 'Send a message to a group',
                            'parameters' => [
                                ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]
                            ],
                            'requestBody' => [
                                'required' => true,
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'user_id' => ['type' => 'string'],
                                                'message' => ['type' => 'string']
                                            ],
                                            'required' => ['user_id','message']
                                        ]
                                    ]
                                ]
                            ],
                            'responses' => [
                                '200' => ['description' => 'Message sent']
                            ]
                        ],
                        'get' => [
                            'summary' => 'Get messages for a group',
                            'parameters' => [
                                ['name' => 'id', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string']]
                            ],
                            'responses' => [
                                '200' => ['description' => 'List of messages']
                            ]
                        ]
                    ]
                ]
            ];

            $res->getBody()->write(json_encode($spec, JSON_PRETTY_PRINT));
            return $res->withHeader('Content-Type', 'application/json');
        });

        $app->get('/docs', function ($req, $res) {
            $html = <<<'HTML'
    <!doctype html>
    <html lang="en">
      <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>bunq-chat API Docs</title>
        <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@4/swagger-ui.css" />
      </head>
      <body>
        <div id="swagger-ui"></div>
        <script src="https://unpkg.com/swagger-ui-dist@4/swagger-ui-bundle.js"></script>
        <script>
          window.ui = SwaggerUIBundle({
            url: '/openapi.json',
            dom_id: '#swagger-ui',
            presets: [SwaggerUIBundle.presets.apis],
            layout: 'BaseLayout'
          });
        </script>
      </body>
    </html>
    HTML;

            $res->getBody()->write($html);
            return $res->withHeader('Content-Type', 'text/html');
        });
};
