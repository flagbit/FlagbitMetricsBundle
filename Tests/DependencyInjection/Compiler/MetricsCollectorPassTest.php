<?php

namespace Flagbit\Bundle\MetricsBundle\Tests\DependencyInjection\Compiler;

use Flagbit\Bundle\MetricsBundle\DependencyInjection\Compiler\MetricsCollectorPass;

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

        $container->expects($this->exactly(2))
            ->method('getDefinition')
            ->will($this->returnValue($definition));

        $container->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->will($this->returnValue($services));

        $definition->expects($this->exactly(2))
            ->method('addMethodCall');

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }
}