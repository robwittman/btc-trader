<?php

namespace BtcTrader\Command\Account;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;

class CoinbaseAccountsCommand extends AbstractCommand
{
    protected $client;

    public function __construct(AuthenticatedClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('account:coinbase');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $accounts = $this->client->getCoinbaseAccounts();
        $climate->table(array_map(function($account) {
            return array(
                'Id' => $account->getId(),
                'Name' => $account->getName(),
                'Balance' => $account->getBalance(),
                'Currency' => $account->getCurrency(),
                'Type' => $account->getType(),
                'Primary' => ($account->isPrimary() ? 'true' : 'false'),
                'Active' => ($account->isActive() ? 'true' : 'false')
            );
        }, $accounts));
    }
}
