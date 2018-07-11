<?php

use Flagbit\Bundle\MetricsBundle\DependencyInjection\Compiler\MetricsCollectorPass;
use Flagbit\Bundle\MetricsBundle\Provider\ProviderInvoker;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class MetricsCollectorPassTest extends TestCase
{
    public function testMetricsProviderNoCollectorThrowsException()
    {
        $services = [
            'my_metric_collector' => [0 => []]
        ];

        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->willReturn($services);

        $this->expectException('InvalidArgumentException');

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }

    public function testValidCollector()
    {
        $services = [
            'my_metric_collector' => [0 => ['collector' => 'librato']]
        ];

        $definition = $this->createMock(Definition::class);
        $container = $this->createMock(ContainerBuilder::class);

        $container->expects($this->atLeastOnce())
            ->method('hasDefinition')
            ->willReturn(true);

        $container->expects($this->once())
            ->method('getDefinition')
            ->with(ProviderInvoker::class)
            ->willReturn($definition);

        $container->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->willReturn($services);

        $definition->expects($this->once())
            ->method('addMethodCall')
            ->with('addMetricsProvider', [
                new Reference('my_metric_collector'),
                [new Reference('beberlei_metrics.collector.librato')]
            ]);

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }
}
