# FlagbitMetricsBundle [![Build Status](https://travis-ci.org/Flagbit/FlagbitMetricsBundle.svg?branch=master)](https://travis-ci.org/Flagbit/FlagbitMetricsBundle) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/073d1c3c-d8d5-4abf-93f5-b2107b33cea8/mini.png)](https://insight.sensiolabs.com/projects/073d1c3c-d8d5-4abf-93f5-b2107b33cea8)

## About

The FlagbitMetricsBundle provides easy integration for the [metrics collector library](https://github.com/beberlei/metrics) 
of Bejamin Beberlei into Symfony2.

## Installation

### Using Composer

Add the following lines to your composer.json:

```json
{
    "require": {
        "flagbit/metrics-bundle", "1.*"
    }
}
```

### Register the bundle

```php
<?php

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Flagbit\Bundle\MetricsBundle\FlagbitMetricsBundle(),
            // ...
        ;)
    }
}
```

## Usage

Don't forget that this bundle has a dependency on the Beberlei Metrics library, first you should integrate and configure
 it. More information can be found [here](https://github.com/beberlei/metrics).

For example, just imagine you want to measure some stats over you application.

### Create your MetricProvider

```php
<?php

namespace Flagbit\ExampleBundle\MetricProvider;

use Flagbit\Bundle\MetricsBundle\Collector\CollectorInterface;
use Flagbit\Bundle\MetricsBundle\Provider\ProviderInterface;

class Provider implements ProviderInterface
{
    public function collectMetrics(CollectorInterface $collector)
    {
        $value = rand(1,9);
        $collector->measure('foo.bar', $value);
    }
}
```

### Create your Service

Once you have created your metric provider class, lets go to create the service. In order the metric collector service 
automatically to collect all the metrics of your metric provider service, you just need to use the "metrics.provider" 
service tag and select so many collectors as you want.

#### YAML

```yml
services:
    my_mailer:
        class:  Flagbit\ExampleBundle\MetricProvider\Provider
        tags:
            - { name: metrics.provider, collector: statsd }
            - { name: metrics.provider, collector: librato }
```
#### XML

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services
        http://symfony.com/schema/dic/services/services-1.0.xsd"
>
    <services>
        <service id="my_mailer" class="Flagbit\ExampleBundle\MetricProvider\Provider">
            <tag name="metrics.provider" collector="statsd" />
            <tag name="metrics.provider" collector="librato" />
        </service>
    </services>
</container>
```

## Collect your Metrics

You can collect all metrics by yourself and after flush them to your metric servers or use the command that does 
it for you instead.

```php
<?php

// Collects the metrics of all you tagged services
$container->get('flagbit_metrics.provider_invoker')->collectMetrics();

// Just necessary if this is a cli task or symfony is running as a daemon
// Otherwise Symfony will do it automatically for you 
$container->get('beberlei_metrics.flush_service')->onTerminate();
```

### Command

```bash
$ php app/console flagbit:metrics:flush
```

