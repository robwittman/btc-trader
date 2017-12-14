<?php

namespace BtcTrader\Command;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Deposit;
use GDAX\Utilities\GDAXConstants;

class PositionCommand extends AbstractCommand
{
    protected $client;

    public function __construct(AuthenticatedClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('position');
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $position = $this->client->getPosition();
        $this->climate->flank('Position', '######');
        $this->climate->out('Status: '.$position->getStatus());
        if (!is_null($position->getFunding())) {
            $this->climate->out('Max Funding Value: '.$position->getFunding()->getMaxFundingValue());
            $this->climate->out('Funding Value: '.$position->getFunding()->getFundingValue());
        }
        $this->climate->table(array_map(function($row) {
            return array(
                'ID' => $row->getId(),
                'Currency' => $row->getCurrency(),
                'Balance' => $row->getBalance(),
                'Hold' => $row->getHold(),
                'Funded Amount' => $row->getFundedAmount(),
                'Default Amount' => $row->getDefaultAmount()
            );
        }, $position->getAccounts()));
    }
}
