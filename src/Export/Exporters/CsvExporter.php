<?php

namespace App\Export\Exporters;

use App\Export\Exporters\ExporterInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CsvExporter implements ExporterInterface
{
    public function __construct(
        private readonly NormalizerInterface $normalizer,
        #[Autowire('%env(CSV_PATH)%')]
        private readonly string $path,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function export(array $tasks): void
    {
        $aTasks = $this->normalizer->normalize($tasks, 'array');
        $file = fopen($this->path, 'w');

        fputcsv($file, \array_keys(reset($aTasks)));

        foreach ($aTasks as $task) {
            fputcsv($file, $task);
        }

        fclose($file);
    }

    public static function getFormat(): string
    {
        return 'csv';
    }
}