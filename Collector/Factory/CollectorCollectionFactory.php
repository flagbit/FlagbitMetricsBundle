<?php

namespace Flagbit\Bundle\MetricsBundle\Collector\Factory;

use Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection;

class CollectorCollectionFactory
{
    /**
     * @param \Beberlei\Metrics\Collector\Collector[] $collectors
     *
     * @return CollectorCollection
     */
    public function create(array $collectors)
    {
        $collectorCollection = new CollectorCollection();

        foreach ($collectors as $collector) {
            $collectorCollection->addCollector($collector);
        }

        return $collectorCollection;
    }
}
