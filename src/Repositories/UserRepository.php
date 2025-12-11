<?php

namespace App\Repositories;

use App\Database;
use App\Models\User;
use PDO;

class UserRepository {
    public function create(string $username): User {
        $db = Database::get();
        $stmt = $db->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->execute([$username]);
        $id = $db->lastInsertId();
        return new User((string)$id, $username);
    }

    public function findById(string $id): ?User {
        $db = Database::get();
        $stmt = $db->prepare('SELECT id, username FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new User((string)$row['id'], $row['username']);
    }

    public function findByUsername(string $username): ?User {
        $db = Database::get();
        $stmt = $db->prepare('SELECT id, username FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return null;
        return new User((string)$row['id'], $row['username']);
    }

    public function getAll(): array {
        $db = Database::get();
        $stmt = $db->query('SELECT id, username FROM users ORDER BY id ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];
        foreach ($rows as $row) {
            $users[] = new User((string)$row['id'], $row['username']);
        }
        return $users;
    }
}
