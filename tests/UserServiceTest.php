<?php

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Models\User;

class UserServiceTest extends TestCase {
    public function testCreateUserDelegatesToRepository() {
       $repo = $this->createMock(UserRepository::class);
       $repo->expects($this->once())
           ->method('create')
           ->with('alice')
           ->willReturn(new User('42', 'alice'));

       $service = new UserService($repo);
       $user = $service->createUser('alice');

       $this->assertInstanceOf(User::class, $user);
       $this->assertEquals('42', $user->id);
    }
}
