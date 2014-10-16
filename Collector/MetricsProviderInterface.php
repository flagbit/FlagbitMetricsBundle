<?php

namespace Flagbit\Bundle\MetricsBundle\Collector;

interface MetricsProviderInterface
{
    /**
     * @param CollectorInterface $collector
     *
     * @return void
     */
    public function collectMetrics(CollectorInterface $collector);
}
