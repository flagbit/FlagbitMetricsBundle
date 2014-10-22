<?php

namespace Flagbit\Bundle\MetricsBundle\Collector\Factory;

use Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection;

class CollectorCollectionFactory
{
    /**
     * @return CollectorCollection
     */
    public function create()
    {
        return new CollectorCollection();
    }
}
