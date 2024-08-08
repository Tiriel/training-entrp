<?php

namespace App\Tests\Unit\Task;

use App\Entity\Category;
use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Task\TaskPrioritizer;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\Clock;

class TaskPrioritizerTest extends TestCase
{
    public function testPrioritizerReturnsArray(): void
    {
        $rep = $this->createMock(TaskRepository::class);
        $prioritizer = new TaskPrioritizer($rep);

        $result = $prioritizer->getPrioritizedTasks(new User());

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }

    public function testPrioritizerSortsTasks(): void
    {
        $tasks = $this->getTasks();
        $this->assertLessThan($tasks[1]->getPriority(), $tasks[0]->getPriority());

        $mock = $this->getMockRepository();
        $mock->expects($this->once())
            ->method('findBy')
            ->willReturn($tasks);

        $prioritizer = new TaskPrioritizer($mock);

        $result = $prioritizer->getPrioritizedTasks(new User());

        $this->assertCount(2, $result);
        $this->assertGreaterThan($result[1]->getPriority(), $result[0]->getPriority());
    }

    private function getTasks(): array
    {

        $cat = (new Category())->setName('urgent')->setPriority(100);
        $t1 = (new Task())
            ->setName('Task one')
            ->setDescription('First task')
            ->setPriority(50)
            ->setCategory($cat)
            ->setCreatedAt(Clock::get()->now());
        $t2 = (new Task())
            ->setName('Task two')
            ->setDescription('Second task')
            ->setPriority(100)
            ->setCategory($cat)
            ->setCreatedAt(Clock::get()->now());

        return [$t1, $t2];
    }

    private function getMockRepository(): MockObject&TaskRepository
    {
        return $this->getMockBuilder(TaskRepository::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->onlyMethods(['findBy'])
            ->getMock();
    }
}
