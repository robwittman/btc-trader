<?php

namespace BtcTrader\Command\Order;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Utilities\GDAXConstants;

class MakeOrderCommand extends AbstractCommand
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
            ->setName('make:order')
            ->addOption('--type', '-t', InputOption::VALUE_OPTIONAL, 'Order Type', GDAXConstants::ORDER_TYPE_LIMIT)
            ->addOption('--size', '-s', InputOption::VALUE_REQUIRED, 'Desired amount in BTC')
            ->addOption('--price', '-p', InputOption::VALUE_OPTIONAL, 'Price to pay per unit')
            ->addOption('--side', null, InputOption::VALUE_OPTIONAL, 'Type of order to place', GDAXConstants::ORDER_SIDE_BUY)
            ->addOption('--post-only', null, InputOption::VALUE_OPTIONAL, 'Should order only make liquidity', true)
            ->addOption('--product-id', null, InputOption::VALUE_OPTIONAL, 'Type of product to buy', GDAXConstants::PRODUCT_ID_BTC_USD)
            ->addOption('--self-trade', null, InputOption::VALUE_OPTIONAL, 'Enable or disable self trade', GDAXConstants::STP_CO)
            ->addOption('--client_oid', '-i', InputOption::VALUE_OPTIONAL, 'Explicitly set order ID')
            ->addOption('--time-in-force', null, InputOption::VALUE_OPTIONAL, '', )
            ->addOption('--cancel', '-c', InputOption::VALUE_OPTIONAL, '')
            ->addOption('--funds', '-f', InputOption::VALUE_OPTIONAL, 'Desired amount of quote currency to use')
            ->addOption
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
