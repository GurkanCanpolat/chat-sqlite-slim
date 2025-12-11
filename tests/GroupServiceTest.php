<?php

use PHPUnit\Framework\TestCase;
use App\Services\GroupService;
use App\Repositories\GroupRepository;
use App\Models\Group;

class GroupServiceTest extends TestCase {
    public function testCreateGroupDelegatesToRepository() {
       $repo = $this->createMock(GroupRepository::class);
       $repo->expects($this->once())
           ->method('create')
           ->with('mygroup')
           ->willReturn(new Group('7', 'mygroup'));

       $service = new GroupService($repo);
       $group = $service->createGroup('mygroup');

       $this->assertInstanceOf(Group::class, $group);
       $this->assertEquals('7', $group->id);
    }

    public function testJoinGroupDelegatesToRepository() {
        $repo = $this->createMock(GroupRepository::class);
        $repo->expects($this->once())
             ->method('addMember')
             ->with('7', '3');

        $service = new GroupService($repo);
        $service->joinGroup('7', '3');

        $this->assertTrue(true); // if no exception, success
    }
}
