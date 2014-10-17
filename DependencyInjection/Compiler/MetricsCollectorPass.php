<?php

namespace Flagbit\Bundle\MetricsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MetricsCollectorPass implements CompilerPassInterface
{
    /**
     * Add tagged metrics.provider services to flagbit_metrics.collector service
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('flagbit_metrics.collector')) {
            return;
        }

        $definition = $container->getDefinition('flagbit_metrics.collector');

        foreach ($container->findTaggedServiceIds('metrics.provider') as $id => $tags) {
            $collectors = array();
            foreach($tags as $attributes) {
                // FIXME collector is optional!
                if (!isset($attributes['collector'])) {
                    throw new \InvalidArgumentException(sprintf(
                            'Metrics provider service "%s" must have an collector attribute in oder to specify a collector',
                            $id
                        ));
                }
                if ($container->hasDefinition('beberlei_metrics.collector.' . $attributes['collector'])) {
                    $collectors[] = new Reference('beberlei_metrics.collector.' . $attributes['collector']);
                }
            }

            if (!empty($collectors)) {
                $definition->addMethodCall('addMetricsProvider', array(new Reference($id), $collectors));
            }
        }
    }
}