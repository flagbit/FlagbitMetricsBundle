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
        $collectionDef = $this->getMock('Symfony\Component\DependencyInjection\Definition');
        $container = $this->getMock('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container->expects($this->atLeastOnce())
            ->method('hasDefinition')
            ->will($this->returnValue(true));

        $container->expects($this->exactly(2))
            ->method('getDefinition')
            ->will($this->returnValueMap(array(
                array('flagbit_metrics.provider_invoker', $definition),
                array('flagbit_metrics.collector.collector_collection', $collectionDef),
            )));

        $container->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->with('metrics.provider')
            ->will($this->returnValue($services));

        $collectionDef->expects($this->once())
            ->method('setArguments')
            ->will($this->returnSelf());

        $definition->expects($this->once())
            ->method('addMethodCall')
            ->with('addMetricsProvider', array(
                new Reference('my_metric_collector'),
                $collectionDef
            ));

        $metricsCollectorPass = new MetricsCollectorPass();
        $metricsCollectorPass->process($container);
    }
}