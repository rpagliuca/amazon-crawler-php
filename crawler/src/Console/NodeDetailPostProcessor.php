<?php
namespace RPagliuca\AmazonCrawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class NodeDetailPostProcessor extends Command
{
    public function __construct(
        \RPagliuca\AmazonCrawler\Business\NodeDetailPostProcessor $instance
    ) {
        $this->instance = $instance;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('post-process-node-details')
            ->setDescription('Extract detailed features from full string')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->instance->execute();
        $output->writeln(json_encode($response));
    }
}
