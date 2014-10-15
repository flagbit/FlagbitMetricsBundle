<?php

namespace Flagbit\MetricsBundle\Collector;

interface CollectorInterface
{
    public function increment($variable);
    public function decrement($variable);
    public function timing($variable, $time);
    public function measure($variable, $value);
}
