<?php

namespace BtcTrader\Command\Account;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Account;

class AccountHistoryCommand extends AbstractCommand
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
            ->setName('account:history')
            ->addArgument('account-id', InputArgument::REQUIRED, 'Account to view');
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $account = (new Account())->setId($input->getArgument('account-id'))->toPaginated();
        $data = $this->client->getAccountHistory($account);
        $climate->table(array_map(function($ledger) {
            return array(
                'id' => $ledger->getId(),
                'created_at' => $ledger->getCreatedAt(),
                'amount' => $ledger->getAmount(),
                'balance' => $ledger->getBalance(),
                'type' => $ledger->getFee()
            );
        }, $data));
    }
}
