<?php

namespace App\Task;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;

class TaskPrioritizer
{
    public function __construct(
        protected readonly TaskRepository $taskRepository,
    )
    {
    }

    public function getPrioritizedTasks(User $user): array
    {
        $tasks = $this->taskRepository->findBy(['createdBy' => $user]);
        $byCategory = [];

        foreach ($tasks as $task) {
            $byCategory[$task->getCategory()->getPriority()][] = $task;
        }

        rsort($byCategory);
        foreach ($byCategory as &$sorted) {
            usort($sorted, fn(Task $a, Task $b) => $b->getPriority() <=> $a->getPriority());
        }

        return \array_merge(...\array_values($byCategory));
    }
}
