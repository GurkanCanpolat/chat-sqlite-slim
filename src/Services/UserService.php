<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    private UserRepository $repo;

    public function __construct(?UserRepository $repo = null) {
        $this->repo = $repo ?? new UserRepository();
    }

    public function createUser(string $username): \App\Models\User {
        return $this->repo->create($username);
    }

    public function getAllUsers(): array {
        return $this->repo->getAll();
    }
}
