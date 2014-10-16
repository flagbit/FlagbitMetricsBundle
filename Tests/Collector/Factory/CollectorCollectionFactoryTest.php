<?php

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

    public function testCreate()
    {
        $this->assertInstanceOf(
            'Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection',
            $this->factory->create()
        );
    }
} 