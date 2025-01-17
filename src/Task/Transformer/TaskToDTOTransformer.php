<?php

namespace App\Task\Transformer;

use App\Dto\TaskRead;
use App\Entity\Task;

class TaskToDTOTransformer
{
    public function transform(Task $task): TaskRead
    {
        if ($task->getCategory() === null) {
            throw new \RuntimeException("All tasks must have a category");
        }

        return new TaskRead(
            $task->getId(),
            $task->getName(),
            $task->getPriority(),
            $task->getDescription(),
            $task->getCategory()->getName(),
            $task->getCreatedAt(),
            $task->getDueAt(),
            $task->getStartAt(),
            $task->getEndAt(),
            $task->isFinished(),
        );
    }
}
