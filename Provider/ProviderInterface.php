<?php

namespace Flagbit\Bundle\MetricsBundle\Provider;

use Flagbit\Bundle\MetricsBundle\Collector\CollectorInterface;

interface ProviderInterface
{
    /**
     * @param CollectorInterface $collector
     *
     * @return void
     */
    public function collectMetrics(CollectorInterface $collector);
}
