<?php

namespace Flagbit\Bundle\MetricsBundle\Tests\DependencyInjection\Compiler;

use Flagbit\Bundle\MetricsBundle\DependencyInjection\Compiler\MetricsCollectorPass;
use Symfony\Component\DependencyInjection\Reference;

class MetricsCollectorPassTest extends \PHPUnit_Framework_TestCase
{
    public function testMetricsProviderNoCollectorThrowsException()
    {
        $services = array(
            'my_metric_collector' => array(0 => array())
        );

        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');
        $container->expects($this->once())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->will($this->returnValue($services));

        $this->setExpectedException('InvalidArgumentException');

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }

    public function testValidCollector()
    {
        $services = array(
            'my_metric_collector' => array(0 => array('collector' => 'librato'))
        );

        $definition = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container->expects($this->atLeastOnce())
            ->method('hasDefinition')
            ->will($this->returnValue(true));

        $container->expects($this->once())
            ->method('getDefinition')
            ->with('flagbit_metrics.provider_invoker')
            ->will($this->returnValue($definition));

        $container->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->will($this->returnValue($services));

        $definition->expects($this->once())
            ->method('addMethodCall')
            ->with('addMetricsProvider', array(
                new Reference('my_metric_collector'),
                array(new Reference('beberlei_metrics.collector.librato'))
            ));

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }
}