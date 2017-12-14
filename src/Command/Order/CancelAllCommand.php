<?php

namespace BtcTrader\Command\Order;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Utilities\GDAXConstants;
use GDAX\Types\Request\Authenticated\Order;

class CancelAllCommand extends AbstractCommand
{
    protected $client;

    public function __construct(AuthenticatedClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('order:cancel_all');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $res = $this->client->cancelOrders();
        var_dump($res);
    }
}
