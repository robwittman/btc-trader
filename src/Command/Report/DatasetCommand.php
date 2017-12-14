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

class DatasetCommand extends AbstractCommand
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
            ->setName('report:dataset')
            ->addArgument('product-id', InputArgument::REQUIRED, 'Product to get stats for')
            ->addOption('--start-time', '-s', InputOption::VALUE_OPTIONAL, 'Start time', null)
            ->addOption('--end-time', '-e', InputOption::VALUE_OPTIONAL, 'End time', null)
            ->addOption('--output', '-o', InputOption::VALUE_REQUIRED, 'Where to store output', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = DateTime::createFromFormat('Y-m-d H:i:s', '2014-01-01 00:00:00');
        $endTime = $startTime->add(new \DateInterval('P1H'));
        $writer = \League\Csv\Writer::createFromPath($input->getOption('output'));
        do {
            $product = (new Product())->setProductId($input->getArgument('product-id'));
            $product->setStart($startTime);
            $product->setEnd($endTime);
            $product->setGranularity(60);

            $rates = $this->client->getProductHistoricRates($product);
            foreach ($rates as $rate) {

            }
        } while (true);
    }
}
