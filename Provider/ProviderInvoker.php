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
     * @var ProviderInterface[]
     */
    private $providers = [];

    /**
     * @var \Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection[]
     */
    private $collectorCollections = [];

    /**
     * @param CollectorCollectionFactory $factory
     */
    public function __construct(CollectorCollectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function collectMetrics()
    {
        foreach ($this->providers as $key => $provider) {
            $provider->collectMetrics($this->collectorCollections[$key]);
        }
    }

    public function onTerminate()
    {
        foreach ($this->collectorCollections as $collectorCollection) {
            $collectorCollection->flush();
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

        $key = spl_object_hash($provider);
        $this->providers[$key] = $provider;
        $this->collectorCollections[$key] = $collectorsCollection;
    }
}
