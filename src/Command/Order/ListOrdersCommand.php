<?php

namespace BtcTrader\Command\Order;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Utilities\GDAXConstants;
use GDAX\Types\Request\Authenticated\ListOrders;

class ListOrdersCommand extends AbstractCommand
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
            ->setName('order:list')
            ->addOption('--status', '-s', InputOption::VALUE_OPTIONAL, 'Get orders of a certain status', GDAXConstants::ORDER_STATUS_ALL)
            ->addOption('--product-id', '-p', InputOption::VALUE_OPTIONAL, 'Product to get orders for', GDAXConstants::PRODUCT_ID_BTC_USD);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $req = (new ListOrders())
            ->setStatus($input->getOption('status'))
            ->setProductId($input->getOption('product-id'));
        $orders = $this->client->getOrders($req);
        var_dump($orders);
    }
}
