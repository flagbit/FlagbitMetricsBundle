<?php

namespace Flagbit\Bundle\MetricsBundle\Collector;

use Beberlei\Metrics\Collector\Collector;

class CollectorCollection implements CollectorInterface
{
    /**
     * @var Collector[]
     */
    private $collectors;

    /**
     * @param Collector $collector
     */
    public function addCollector(Collector $collector)
    {
        $this->collectors[] = $collector;
    }

    /**
     * {@inheritdoc}
     */
    function increment($variable)
    {
        $this->callAll('increment', [$variable]);
    }

    /**
     * {@inheritdoc}
     */
    function decrement($variable)
    {
        $this->callAll('decrement', [$variable]);
    }

    /**
     * {@inheritdoc}
     */
    function timing($variable, $time)
    {
        $this->callAll('timing', [$variable, $time]);
    }

    /**
     * {@inheritdoc}
     */
    function measure($variable, $value)
    {
        $this->callAll('measure', [$variable, $value]);
    }

    /**
     * {@inheritdoc}
     */
    private function callAll($method, array $arguments)
    {
        foreach ($this->collectors as $collector) {
            $collector->{$method}(...$arguments);
        }
    }
}
