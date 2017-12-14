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
use DateTime;

class HistoricRateCommand extends AbstractCommand
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
            ->setName('report:historic')
            ->addArgument('product-id', InputArgument::REQUIRED, 'Product to get stats for')
            ->addOption('--start-time', '-s', InputOption::VALUE_OPTIONAL, 'Start time', null)
            ->addOption('--end-time', '-e', InputOption::VALUE_OPTIONAL, 'End time', null)
            ->addOption('--interval', '-i', InputOption::VALUE_OPTIONAL, 'Interval for fetching data', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $product = (new Product())->setProductId($input->getArgument('product-id'));
        if ($input->getOption('start-time')) {
            $product->setStart(new DateTime($input->getOption('start-time')));
        }
        if ($input->getOption('end-time')) {
            $product->setEnd(new DateTime($input->getOption('end-time')));
        }
        if ($input->getOption('interval')) {
            $product->setGranularity($input->getOption('interval'));
        }
        $rates = $this->client->getProductHistoricRates($product);
        var_dump($rates);
    }
}
