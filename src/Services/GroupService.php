<?php

namespace App\Services;

use App\Repositories\GroupRepository;

class GroupService {
    private GroupRepository $repo;

    public function __construct(?GroupRepository $repo = null) {
        $this->repo = $repo ?? new GroupRepository();
    }

    public function createGroup(string $name): \App\Models\Group {
        return $this->repo->create($name);
    }

    public function joinGroup(string $groupId, string $userId): void {
        $this->repo->addMember($groupId, $userId);
    }
}
