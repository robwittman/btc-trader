<?php

namespace BtcTrader\Command\Account;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Account;

class AccountHoldsCommand extends AbstractCommand
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
            ->setName('account:holds')
            ->addArgument('account-id', InputArgument::REQUIRED, 'Account to view');
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $account = (new Account())->setId($input->getArgument('account-id'))->toPaginated();
        $data = $this->client->getAccountHolds($account);
        $climate->table(array_map(function($hold) {

        }, $data));
    }
}
