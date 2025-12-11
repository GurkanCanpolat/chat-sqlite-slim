<?php

namespace App\Services;

use App\Repositories\MessageRepository;
use App\Models\Message;

class MessageService {
    private MessageRepository $repo;

    public function __construct(?MessageRepository $repo = null) {
        $this->repo = $repo ?? new MessageRepository();
    }

    public function sendMessage(string $groupId, string $userId, string $text): Message {
        return $this->repo->create($groupId, $userId, $text);
    }

    public function getMessages(string $groupId): array {
        return $this->repo->getByGroup($groupId);
    }
}
