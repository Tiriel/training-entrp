<?php

namespace App\Export;

use App\Entity\User;
use App\Task\TaskPrioritizer;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireLocator;

class Exporter
{
    public function __construct(
        private readonly TaskPrioritizer $prioritizer,
        #[AutowireLocator('app.task_exporter', defaultIndexMethod: 'getFormat')]
        private ContainerInterface $locator,
    )
    {
    }

    public function export(User $user, string $format = 'csv'): void
    {
        $tasks = $this->prioritizer->getPrioritizedTasks($user);
        $exporter = $this->locator->get($format);
        $exporter->export($tasks);
    }
}