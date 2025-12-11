<?php

namespace App\Repositories;

use App\Database;
use App\Models\Message;

class MessageRepository {
    public function create(string $groupId, string $userId, string $text): Message {
        $db = Database::get();

        $stmt = $db->prepare(
            "INSERT INTO messages (group_id, user_id, message, created_at) 
             VALUES (?, ?, ?, datetime('now'))"
        );
        $stmt->execute([$groupId, $userId, $text]);
        $id = $db->lastInsertId();

        // fetch created_at
        $stmt = $db->prepare('SELECT created_at FROM messages WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return new Message((string)$id, $groupId, $userId, $text, $row['created_at'] ?? '');
    }

    public function getByGroup(string $groupId): array {
        $db = Database::get();
        $stmt = $db->prepare(
            "SELECT messages.id, users.username, messages.message, messages.created_at, messages.user_id
             FROM messages
             JOIN users ON messages.user_id = users.id
             WHERE messages.group_id = ?
             ORDER BY messages.created_at ASC"
        );
        $stmt->execute([$groupId]);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($rows as $r) {
            $messages[] = new Message((string)$r['id'], $groupId, (string)$r['user_id'], $r['message'], $r['created_at']);
        }
        return $messages;
    }

    public function findById(string $id): ?\App\Models\Message {
        $db = Database::get();
        $stmt = $db->prepare('SELECT id, group_id, user_id, message, created_at FROM messages WHERE id = ?');
        $stmt->execute([$id]);
        $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new \App\Models\Message((string)$r['id'], (string)$r['group_id'], (string)$r['user_id'], $r['message'], $r['created_at']);
    }
}
