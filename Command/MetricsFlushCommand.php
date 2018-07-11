<?php

namespace Flagbit\Bundle\MetricsBundle\Command;

use Flagbit\Bundle\MetricsBundle\Provider\ProviderInvoker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MetricsFlushCommand extends Command
{
    /**
     * @var ProviderInvoker
     */
    private $providerInvoker;

    /**
     * @param ProviderInvoker $providerInvoker
     */
    public function __construct(ProviderInvoker $providerInvoker)
    {
        parent::__construct('flagbit:metrics:flush');
        $this->providerInvoker = $providerInvoker;
    }

    protected function configure()
    {
        $this->setDescription('Collect metrics and flush them to the metric collector servers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Collect job status metrics
        $this->providerInvoker->collectMetrics();
        // Flush metric results
        $this->providerInvoker->onTerminate();
    }
}
