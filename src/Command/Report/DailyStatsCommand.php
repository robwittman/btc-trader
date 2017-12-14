<?php

namespace BtcTrader\Command\Report;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\PublicClient;
use GDAX\Utilities\GDAXConstants;
use GDAX\Types\Request\Authenticated\Order;
use GDAX\Types\Request\Market\Product;

class DailyStatsCommand extends AbstractCommand
{
    protected $client;

    public function __construct(PublicClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this
            ->setName('report:daily')
            ->addArgument('product-id', InputArgument::REQUIRED, 'Product to get stats for');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $product = (new Product())->setProductId($input->getArgument('product-id'));
        $rates = $this->client->getProduct24HrStats($product);
        var_dump($rates);
    }
}
