<?php
namespace RPagliuca\AmazonCrawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GetCsvCommand extends Command
{
    public function __construct(
        \RPagliuca\AmazonCrawler\Business\LinksCsvPrinter $linksCsvPrinter
    ) {
        $this->linksCsvPrinter = $linksCsvPrinter;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('get-links-as-csv')
            ->setDescription('Get CSV containing all links between nodes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $errorBag = new \RPagliuca\AmazonCrawler\System\ErrorBag;
        $csv = $this->linksCsvPrinter->print(
            $errorBag
        );
        $output->writeln($csv);
    }
}
