<?php

namespace App\Tests\Unit\Task\Transformer;

use App\Dto\TaskRead;
use App\Entity\Category;
use App\Entity\Task;
use App\Task\Transformer\TaskToDTOTransformer;
use PHPUnit\Framework\TestCase;

class TaskToDTOTransformerTest extends TestCase
{
    protected static TaskToDTOTransformer $transformer;

    public static function setUpBeforeClass(): void
    {
        static::$transformer = new TaskToDTOTransformer();
    }

    public function testTransformerReturnsTaskReadDtoInstance(): void
    {
        $obj = static::$transformer->transform($this->createTask());

        $this->assertInstanceOf(TaskRead::class, $obj);
    }

    public function testDtoHasOriginalObjectsName(): void
    {
        $obj = static::$transformer->transform($this->createTask());

        $this->assertSame('test', $obj->getName());
    }

    public function testExceptionIsThrownIfCategoryIsNull(): void
    {
        $this->expectException(\RuntimeException::class);

        $obj = static::$transformer->transform($this->createTask(false));
    }

    private function createTask(bool $withCategory = true): Task
    {
        $task = (new Task())->setName('test');

        if ($withCategory) {
           $task->setCategory((new Category())->setName('urgent'));
        }

        return $task;
    }
}
