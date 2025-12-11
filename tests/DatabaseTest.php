<?php

use PHPUnit\Framework\TestCase;
use App\Database;

class DatabaseTest extends TestCase
{
    public function testGetReturnsPdoInstance()
    {
        $db = Database::get();
        $this->assertInstanceOf(\PDO::class, $db);

        // Singleton: multiple calls return same instance
        $db2 = Database::get();
        $this->assertSame($db, $db2);
    }
}
