<?php

namespace Flagbit\Bundle\MetricsBundle\Collector;

use Beberlei\Metrics\Collector\Collector;

class CollectorCollection implements CollectorInterface
{
    /**
     * @var array
     */
    private $collectors = array();

    /**
     * @param Collector $collector
     */
    public function addCollector(Collector $collector)
    {
        $this->collectors[] = $collector;
    }

    /**
     * @param string $variable
     */
    function increment($variable)
    {
        $this->callAll('increment', array($variable));
    }

    /**
     * @param string $variable
     */
    function decrement($variable)
    {
        $this->callAll('decrement', array($variable));
    }

    /**
     * @param string $variable
     * @param float  $time
     */
    function timing($variable, $time)
    {
        $this->callAll('timing', array($variable, $time));
    }

    /**
     * @param string $variable
     * @param int    $value
     */
    function measure($variable, $value)
    {
        $this->callAll('measure', array($variable, $value));
    }

    /**
     * @param string $method
     * @param array  $arguments
     */
    private function callAll($method, array $arguments)
    {
        foreach ($this->collectors as $collector) {
            call_user_func_array(array($collector, $method), $arguments);
        }
    }
}
