<?php

namespace Flagbit\MetricsBundle\Collector;

interface MetricsProviderInterface
{
    /**
     * @param CollectorInterface $collector
     *
     * @return void
     */
    public function collectMetrics(CollectorInterface $collector);
}
