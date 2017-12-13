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

class CancelOrderCommand extends AbstractCommand
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
            ->setName('order:cancel')
            ->addArgument('order-id', InputArgument::REQUIRED, 'Order to cancel');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $order = (new Order())->setId($input->getArgument('order-id'));
        $res = $this->client->cancelOrder($order);
        if ($res->getMessage()) {
            $this->climate->error($res->getMessage());
        } else {
            $this->climate->out('Order '.$input->getArgument('order-id').' cancelled');
        }
    }
}
