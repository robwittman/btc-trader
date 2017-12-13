<?php

namespace BtcTrader\Command\Account;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Account;

class ShowAccountCommand extends AbstractCommand
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
            ->setName('account:show')
            ->addArgument('account-id', InputArgument::REQUIRED, 'Account to view');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $account = (new Account())->setId($input->getArgument('account-id'));
        $data = $this->client->getAccount($account);
        $climate->table(array(array(
            'id' => $data->getId(),
            'currency' => $data->getCurrency(),
            'balance' => $data->getBalance(),
            'available' => $data->getAvailable(),
            'hold' => $data->getHold(),
            'profile_id' => $data->getProfileId()
        )));
    }
}
