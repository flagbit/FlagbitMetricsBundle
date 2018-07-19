<?php

namespace Flagbit\Bundle\MetricsBundle\DependencyInjection\Compiler;

use Flagbit\Bundle\MetricsBundle\Provider\ProviderInvoker;
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
        if (false === $container->hasDefinition(ProviderInvoker::class)) {
            return;
        }

        $definition = $container->getDefinition(ProviderInvoker::class);

        foreach ($container->findTaggedServiceIds('metrics.provider') as $id => $tags) {
            $collectors = [];
            foreach($tags as $attributes) {
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
                $definition->addMethodCall('addMetricsProvider', [new Reference($id), $collectors]);
            }
        }
    }
}
