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

class DepositCommand extends AbstractCommand
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
            ->setName('make:deposit')
            ->addOption('--amount', '-a', InputOption::VALUE_REQUIRED, 'Amount to deposit', null)
            ->addOption('--currency', '-c', InputOption::VALUE_REQUIRED, 'Currency', null)
            ->addOption('--source', '-s', InputOption::VALUE_OPTIONAL, 'Source to deposit from', null)
            ->addOption('--coinbase-account-id', '-x', InputOption::VALUE_OPTIONAL, 'Coinbase account to transfer funds from');
}

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (is_null($input->getOption('source')) && is_null($input->getOption('coinbase-account-id'))) {
            throw new \Exception(
                "Command make:deposit requires either a source or coinbase account id"
            );
        }
        $deposit = (new Deposit())
            ->setAmount($input->getOption('amount'))
            ->setCurrency($input->getOption('currency'));
        if ($input->getOption('source')) {
            $deposit->setPaymentMethodId($input->getOption('source'));
            $res = $this->client->depositPaymentMethod($deposit);
        } else {
            $deposit->setCoinbaseAccountId($input->getOption('coinbase-account-id'));
            $res = $this->client->depositCoinbase($deposit);
        }
        if ($res->getMessage()) {
            throw new \Exception($res->getMessage());
        }
        $climate = $this->getClimate();
        $climate->table(array(array(
            'id' => $res->getId(),
            'amount' => $res->getAmount(),
            'currency' => $res->getCurrency()
        )));
    }
}
