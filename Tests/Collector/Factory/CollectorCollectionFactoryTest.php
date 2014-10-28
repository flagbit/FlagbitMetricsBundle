<?php

namespace Flagbit\Bundle\MetricsBundle\Tests\Collector\Factory;

use Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory;

class CollectorCollectionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CollectorCollectionFactory
     */
    private $factory;

    protected function setUp()
    {
        $this->factory = new CollectorCollectionFactory();
    }

    public function testCreateEmpty()
    {
        $this->assertInstanceOf(
            'Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection',
            $this->factory->create(array())
        );
    }

    public function testCreate()
    {
        $collector = $this->getMock('Beberlei\Metrics\Collector\Collector');

        $this->assertInstanceOf(
            'Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection',
            $this->factory->create(array($collector))
        );
    }
} 