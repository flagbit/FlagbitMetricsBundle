<?php

namespace Flagbit\Bundle\MetricsBundle\Provider;

interface MetricsProviderInterface
{
    /**
     * @param CollectorInterface $collector
     *
     * @return void
     */
    public function collectMetrics(CollectorInterface $collector);
}
