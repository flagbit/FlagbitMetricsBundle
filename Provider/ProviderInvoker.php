<?php

namespace Flagbit\Bundle\MetricsBundle\Provider;

use Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory;
use Flagbit\Bundle\MetricsBundle\Collector\CollectorInterface;

class ProviderInvoker
{
    /**
     * @var CollectorCollectionFactory
     */
    private $factory;

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
     * @param ProviderInterface $provider
     * @param CollectorInterface $collectorsCollection
     */
    public function addMetricsProvider(ProviderInterface $provider, CollectorInterface $collectorsCollection)
    {
        $this->providers[] = array(
            'provider' => $provider,
            'collector' => $collectorsCollection,
        );
    }
}
