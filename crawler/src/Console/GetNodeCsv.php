<?php
namespace RPagliuca\AmazonCrawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GetNodeCsv extends Command
{
    public function __construct(
        \RPagliuca\AmazonCrawler\Business\NodesCsvPrinter $nodesCsvPrinter
    ) {
        $this->nodesCsvPrinter = $nodesCsvPrinter;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('get-nodes-as-csv')
            ->setDescription('Get CSV containing all nodes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $errorBag = new \RPagliuca\AmazonCrawler\System\ErrorBag;
        $csv = $this->nodesCsvPrinter->print(
            $errorBag
        );
        $output->writeln($csv);
    }
}
