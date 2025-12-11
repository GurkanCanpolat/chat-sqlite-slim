<?php

use PHPUnit\Framework\TestCase;
use App\Database;
use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;

class RepositoryIntegrationTest extends TestCase {
    private \PDO $pdo;

    protected function setUp(): void {
        // Create in-memory SQLite and set it on Database singleton via reflection
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create minimal schema
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT UNIQUE);");
        $this->pdo->exec("CREATE TABLE groups (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT);");
        $this->pdo->exec("CREATE TABLE group_members (group_id INTEGER, user_id INTEGER, UNIQUE(group_id,user_id));");

        // Inject into App\Database::$instance
    $ref = new ReflectionClass(Database::class);
    // PHP 8.5: ReflectionProperty::setAccessible is deprecated and unnecessary for public/protected static property access.
    // Use setStaticPropertyValue to set the private static PDO instance.
    $ref->setStaticPropertyValue('instance', $this->pdo);
    }

    public function testUserRepositoryCreateAndRetrieveId() {
        $userRepo = new UserRepository();
    $user = $userRepo->create('int_test_user');
    $this->assertNotEmpty($user->id);

    // ensure record exists
    $stmt = $this->pdo->prepare('SELECT username FROM users WHERE id = ?');
    $stmt->execute([$user->id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->assertEquals('int_test_user', $row['username']);
    }

    public function testGroupRepositoryCreateAndAddMember() {
    $groupRepo = new GroupRepository();
    $group = $groupRepo->create('int_test_group');
    $this->assertNotEmpty($group->id);

    // create a user
    $userRepo = new UserRepository();
    $user = $userRepo->create('int_test_user2');

    // add member (pass ids)
    $groupRepo->addMember($group->id, $user->id);

    $stmt = $this->pdo->prepare('SELECT user_id FROM group_members WHERE group_id = ?');
    $stmt->execute([$group->id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->assertEquals($user->id, (string)$row['user_id']);
    }
}
