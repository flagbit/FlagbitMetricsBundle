<?php

namespace Flagbit\Bundle\MetricsBundle\Provider;

use Beberlei\Metrics\Collector\Collector;
use Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory;

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
     * @param Collector[]       $collectors
     */
    public function addMetricsProvider(ProviderInterface $provider, array $collectors)
    {
        $collectorsCollection = $this->factory->create();
        foreach ($collectors as $collector) {
            $collectorsCollection->addCollector($collector);
        }

        $this->providers[] = array(
            'provider' => $provider,
            'collector' => $collectorsCollection,
        );
    }
}
