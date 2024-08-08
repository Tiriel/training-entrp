<?php

namespace App\Tests\Unit\Task\Transformer;

use App\Dto\TaskRead;
use App\Entity\Task;
use App\Task\Transformer\TaskToDTOTransformer;
use PHPUnit\Framework\TestCase;

class TaskToDTOTransformerTest extends TestCase
{
    public function testTransformerReturnsTaskReadDtoInstance(): void
    {
        $transformer = new TaskToDTOTransformer();
        $obj = $transformer->transform((new Task())
            ->setName('test')
        );

        $this->assertInstanceOf(TaskRead::class, $obj);
    }

    public function testDtoHasOriginalObjectsName(): void
    {
        $transformer = new TaskToDTOTransformer();
        $obj = $transformer->transform((new Task())
            ->setName('test')
        );

        $this->assertSame('test', $obj->getName());
    }
}
