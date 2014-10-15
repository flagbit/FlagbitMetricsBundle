<?php

namespace Flagbit\MetricsBundle;

use Flagbit\MetricsBundle\DependencyInjection\Compiler\MetricsCollectorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Scope;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FlagbitMetricsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::boot($container);

        $container->addCompilerPass(new MetricsCollectorPass());
    }
}
