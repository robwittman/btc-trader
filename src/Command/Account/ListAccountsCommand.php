<?php

namespace BtcTrader\Command\Account;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;

class ListAccountsCommand extends AbstractCommand
{
    protected $client;

    public function __construct(AuthenticatedClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('account:list');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $accounts = $this->client->getAccounts();
        $climate->table(array_map(function($account) {
            return array(
                'id' => $account->getId(),
                'currency' => $account->getCurrency(),
                'balance' => $account->getBalance(),
                'available' => $account->getAvailable(),
                'hold' => $account->getHold(),
                'profile_id' => $account->getProfileId()
            );
        }, $accounts));
    }
}
