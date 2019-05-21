<?php
namespace RPagliuca\AmazonCrawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InitialDataInitializerCommand extends Command
{
    public function __construct(
        \RPagliuca\AmazonCrawler\Setup $instance
    ) {
        $this->instance = $instance;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('setup-insert-initial-data')
            ->setDescription('Insert initial database rows for node 1')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->instance->run();
        $output->writeln($response);
    }
}
