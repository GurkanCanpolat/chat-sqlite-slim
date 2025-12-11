<?php

namespace App\Models;

class GroupMember implements \JsonSerializable {
    public string $groupId;
    public string $userId;

    public function __construct(string $groupId, string $userId) {
        $this->groupId = $groupId;
        $this->userId = $userId;
    }

    public function jsonSerialize(): mixed {
        return [
            'group_id' => $this->groupId,
            'user_id' => $this->userId,
        ];
    }
}
