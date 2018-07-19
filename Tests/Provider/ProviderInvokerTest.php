<?php

use Beberlei\Metrics\Collector\Collector;
use Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection;
use Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory;
use Flagbit\Bundle\MetricsBundle\Provider\ProviderInterface;
use Flagbit\Bundle\MetricsBundle\Provider\ProviderInvoker;
use PHPUnit\Framework\TestCase;

class ProviderInvokerTest extends TestCase
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
        $this->factory = $this->createMock(CollectorCollectionFactory::class);
        $this->metricsProvider = new ProviderInvoker($this->factory);
    }

    public function testAddMetricsProvider()
    {
        $collector = $this->createMock(Collector::class);
        $provider = $this->createMock(ProviderInterface::class);

        $this->getCollectorCollection($collector);

        $this->metricsProvider->addMetricsProvider($provider, [$collector]);
    }

    public function testCollectMetrics()
    {
        $collector = $this->createMock(Collector::class);
        $provider = $this->createMock(ProviderInterface::class);
        $collectorCollection = $this->getCollectorCollection($collector);

        $provider
            ->expects($this->once())
            ->method('collectMetrics')
            ->with($collectorCollection);

        $this->metricsProvider->addMetricsProvider($provider, [$collector]);
        $this->metricsProvider->collectMetrics();
    }

    public function testOnTerminate()
    {
        $collector = $this->createMock(Collector::class);
        $provider = $this->createMock(ProviderInterface::class);
        $collectorCollection = $this->getCollectorCollection($collector);

        $provider
            ->expects($this->once())
            ->method('collectMetrics')
            ->with($collectorCollection);

        $this->metricsProvider->addMetricsProvider($provider, [$collector]);
        $this->metricsProvider->collectMetrics();
    }

    private function getCollectorCollection($collector)
    {
        $collectorCollection = $this->createMock(CollectorCollection::class);

        $this->factory
            ->expects($this->once())
            ->method('create')
            ->willReturn($collectorCollection);

        $collectorCollection
            ->expects($this->once())
            ->method('addCollector')
            ->with($collector);

        return $collectorCollection;
    }
}
