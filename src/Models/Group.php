<?php

namespace App\Models;

class Group implements \JsonSerializable {
    public string $id;
    public string $name;

    public function __construct(string $id, string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
