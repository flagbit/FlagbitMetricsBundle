<?php

namespace Flagbit\Bundle\MetricsBundle\Collector;

use Beberlei\Metrics\Collector\Collector;

class MetricsCollector
{
    /**
     * @var array
     */
    private $providers = array();

    public function collectMetrics()
    {
        foreach ($this->providers as $provider) {
            $provider['provider']->collectMetrics($provider['collector']);
        }
    }

    /**
     * @param MetricsProviderInterface $provider
     * @param Collector[]              $collectors
     */
    public function addMetricsProvider(MetricsProviderInterface $provider, array $collectors)
    {
        $collectorsCollection = new CollectorCollection();
        foreach ($collectors as $collector) {
            $collectorsCollection->addCollector($collector);
        }

        $this->providers[] = array(
            'provider' => $provider,
            'collector' => $collectorsCollection,
        );
    }
} 