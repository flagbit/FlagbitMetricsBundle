<?php

namespace Flagbit\Bundle\MetricsBundle\Provider;

use Beberlei\Metrics\Collector\Collector;
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

    /**
     * @param CollectorCollectionFactory $factory
     */
    public function __construct(CollectorCollectionFactory $factory)
    {
        $this->factory = $factory;
    }

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
