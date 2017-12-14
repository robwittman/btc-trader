<?php

namespace BtcTrader\Command;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Withdrawal;
use GDAX\Utilities\GDAXConstants;

class WithdrawCommand extends AbstractCommand
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
            ->setName('withdraw')
            ->addOption('--amount', '-a', InputOption::VALUE_REQUIRED, 'How much to withdraw')
            ->addOption('--currency', '-c', InputOption::VALUE_REQUIRED, 'The type of currency')
            ->addOption('--destination', '-d', InputOption::VALUE_REQUIRED, 'Where to send the money')
            ->addOption('--destination-type', '-t', InputOption::VALUE_OPTIONAL, 'The type of receiving account', 'payment-method');
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $withdraw = (new Withdrawal())
            ->setAmount($input->getOption('amount'))
            ->setCurrency($input->getOption('currency'));

        $destination = $input->getOption('destination');
        switch ($input->getOption('destination-type')) {
            case 'coinbase':
                $withdraw->setCoinbaseAccountId($destination);
                $res = $this->client->withdawCoinbase($withdraw);
                break;
            case 'crypto':
                $withdraw->setCryptoAddress($destination);
                $res = $this->client->withdrawCrypto($withdraw);
                break;
            default:
                $withdraw->setPaymentMethodId($destination);
                $res = $this->client->withdrawPaymentMethod($withdraw);

        }
        if (!is_null($res->getMessage())) {
            $this->climate->error($res->getMessage());
        }
        var_dump($res);
        $this->climate->out('Withdrawal successful');
    }
}
