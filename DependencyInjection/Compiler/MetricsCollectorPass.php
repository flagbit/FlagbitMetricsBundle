<?php

namespace Flagbit\MetricsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MetricsCollectorPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $ourFancyCollectorDefinition = $container->findDefinition('flagbit_metrics.collector');

        foreach ($container->findTaggedServiceIds('metrics.provider') as $id => $tags) {
            $collectors = array();
            foreach($tags as $attributes) {
                // FIXME collector is optional!

                $collectors[] = new Reference('beberlei_metrics.collector.' . $attributes['collector']);
            }

            $ourFancyCollectorDefinition->addMethodCall('addMetricsProvider', array(new Reference($id), $collectors));
        }
    }
}