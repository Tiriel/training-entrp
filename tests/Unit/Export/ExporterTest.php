<?php

namespace App\Tests\Unit\Export;

use App\Entity\User;
use App\Export\Exporter;
use App\Export\Exporters\CsvExporter;
use App\Task\TaskPrioritizer;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Container\ContainerInterface;

class ExporterTest extends TestCase
{
    use ProphecyTrait;

    public function testExportCallsDependencies(): void
    {
        $prioritizerMock = $this->prophesize(TaskPrioritizer::class);
        $prioritizerMock->getPrioritizedTasks(Argument::type(User::class))
            ->shouldBeCalled()
            ->willReturn(['called']);

        //$csvMock = $this->getMockBuilder(CsvExporter::class)
        //    ->disableOriginalConstructor()
        //    ->disableOriginalClone()
        //    ->disableArgumentCloning()
        //    ->disallowMockingUnknownTypes()
        //    ->onlyMethods(['export'])
        //    ->getMock();
        //$csvMock->expects($this->once())
        //    ->method('export')
        //    ->with(['called']);
        $csvMock = $this->prophesize(CsvExporter::class);
        $csvMock->export(Argument::is(['called']))
            ->shouldBeCalled();

        $containerMock = $this->prophesize(ContainerInterface::class);
        $containerMock->get(Argument::is('csv'))
            ->shouldBeCalled()
            ->willReturn($csvMock->reveal());

        $exporter = new Exporter($prioritizerMock->reveal(), $containerMock->reveal());
        $exporter->export(new User(), 'csv');
    }
}
