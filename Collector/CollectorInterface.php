<?php

namespace Flagbit\Bundle\MetricsBundle\Collector;

interface CollectorInterface
{
    /**
     * @param string $variable
     */
    public function increment($variable);

    /**
     * @param string $variable
     */
    public function decrement($variable);

    /**
     * @param string $variable
     * @param float  $time
     */
    public function timing($variable, $time);

    /**
     * @param string $variable
     * @param int    $value
     */
    public function measure($variable, $value);
}
