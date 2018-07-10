<?php

use Flagbit\Bundle\MetricsBundle\Collector\CollectorCollection;
use Flagbit\Bundle\MetricsBundle\Collector\Factory\CollectorCollectionFactory;
use PHPUnit\Framework\TestCase;

class CollectorCollectionFactoryTest extends TestCase
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
            CollectorCollection::class,
            $this->factory->create()
        );
    }
} 
