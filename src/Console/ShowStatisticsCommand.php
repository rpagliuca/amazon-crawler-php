<?php
namespace RPagliuca\AmazonCrawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ShowStatisticsCommand extends Command
{
    public function __construct(
        \RPagliuca\AmazonCrawler\Business\StatisticsGatherer $instance
    ) {
        $this->instance = $instance;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('show-statistics')
            ->setDescription('Show a few crawler statistics')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->instance->getStatistics();
        $output->writeln(json_encode($response));
    }
}
