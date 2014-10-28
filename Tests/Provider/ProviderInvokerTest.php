<?php

namespace Flagbit\Bundle\MetricsBundle\Tests\Provider;

use Flagbit\Bundle\MetricsBundle\Provider\ProviderInvoker;

class ProviderInvokerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $factory;

    /**
     * @var ProviderInvoker
     */
    private $metricsProvider;

    protected function setUp()
    {
        $this->factory = $this->getMock('Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory');
        $this->metricsProvider = new ProviderInvoker($this->factory);
    }

    public function testAddMetricsProvider()
    {
        $collectorCollection = $this->getMock('Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection');
        $provider = $this->getMock('Flagbit\Bundle\MetricsBundle\Provider\ProviderInterface');

        $this->metricsProvider->addMetricsProvider($provider, $collectorCollection);
    }

    public function testCollectMetrics()
    {
        $collectorCollection = $this->getMock('Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection');
        $provider = $this->getMock('Flagbit\Bundle\MetricsBundle\Provider\ProviderInterface');

        $provider
            ->expects($this->once())
            ->method('collectMetrics')
            ->with($collectorCollection);

        $this->metricsProvider->addMetricsProvider($provider, $collectorCollection);
        $this->metricsProvider->collectMetrics();
    }
}