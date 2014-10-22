<?php

namespace Flagbit\Bundle\MetricsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MetricsFlushCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('flagbit:metrics:flush')
            ->setDescription('Collect metrics and flush them to the metric collector servers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Collect job status metrics
        $this->getContainer()->get('flagbit_metrics.provider_invoker')->collectMetrics();
        // Flush metric results
        $this->getContainer()->get('beberlei_metrics.flush_service')->onTerminate();
    }
} 