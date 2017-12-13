<?php

namespace BtcTrader\Command\Funding;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Funding;
use GDAX\Utilities\GDAXConstants;

class ListFundingsCommand extends AbstractCommand
{
    protected $client;

    public function __construct(AuthenticatedClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this
            ->setName('funding:list')
            ->addOption('--status', 's', InputOption::VALUE_OPTIONAL, 'Status of fundings to fetch', GDAXConstants::FUNDING_STATUS_SETTLED);
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $funding = (new Funding())
            ->setStatus($input->getOption('status'));
        $data = $this->client->getFundings($funding);
        var_dump($data);
    }
}
