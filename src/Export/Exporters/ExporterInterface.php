<?php

namespace App\Export\Exporters;

use App\Entity\Task;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.task_exporter')]
interface ExporterInterface
{
    /**
     * @param Task[] $tasks
     * @return void
     */
    public function export(array $tasks): void;

    public static function getFormat(): string;
}