<?php

namespace App\Models;

class User implements \JsonSerializable {
    public string $id;
    public string $username;

    public function __construct(string $id, string $username) {
        $this->id = $id;
        $this->username = $username;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];
    }
}
