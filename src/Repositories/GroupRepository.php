<?php

namespace App\Repositories;

use App\Database;
use App\Models\Group;
use PDO;

class GroupRepository {
    public function create(string $name): Group {
        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO groups (name) VALUES (?)");
        $stmt->execute([$name]);
        $id = $db->lastInsertId();
        return new Group((string)$id, $name);
    }

    public function addMember(string $groupId, string $userId): void {
        $db = Database::get();
        $stmt = $db->prepare("INSERT OR IGNORE INTO group_members (group_id, user_id) VALUES (?, ?)");
        $stmt->execute([$groupId, $userId]);
    }

    public function findById(string $id): ?Group {
        $db = Database::get();
        $stmt = $db->prepare('SELECT id, name FROM groups WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new Group((string)$row['id'], $row['name']);
    }

    public function getMembers(string $groupId): array {
        $db = Database::get();
        $stmt = $db->prepare('SELECT u.id, u.username FROM users u JOIN group_members gm ON u.id = gm.user_id WHERE gm.group_id = ?');
        $stmt->execute([$groupId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $members = [];
        foreach ($rows as $r) {
            $members[] = new \App\Models\User((string)$r['id'], $r['username']);
        }
        return $members;
    }
}
