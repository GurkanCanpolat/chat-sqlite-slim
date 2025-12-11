<?php

namespace App\Models;

class Message implements \JsonSerializable {
    public string $id;
    public string $groupId;
    public string $userId;
    public string $text;
    public string $createdAt;

    public function __construct(string $id, string $groupId, string $userId, string $text, string $createdAt) {
        $this->id = $id;
        $this->groupId = $groupId;
        $this->userId = $userId;
        $this->text = $text;
        $this->createdAt = $createdAt;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'group_id' => $this->groupId,
            'user_id' => $this->userId,
            'text' => $this->text,
            'created_at' => $this->createdAt,
        ];
    }
}
