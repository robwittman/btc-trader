<?php

namespace BtcTrader\Command\Order;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\PublicClient;
use GDAX\Types\Request\Market\Product;
use GDAX\Utilities\GDAXConstants;

class OrderWatchCommand extends AbstractCommand
{
    protected $client;

    protected $products = array(
        GDAXConstants::PRODUCT_ID_BTC_USD,
        GDAXConstants::PRODUCT_ID_BTC_EUR,
        GDAXConstants::PRODUCT_ID_BTC_GBP,
        GDAXConstants::PRODUCT_ID_ETH_USD,
        GDAXConstants::PRODUCT_ID_ETH_EUR,
        GDAXConstants::PRODUCT_ID_LTC_USD,
        GDAXConstants::PRODUCT_ID_LTC_EUR,
        GDAXConstants::PRODUCT_ID_LTC_BTC,
        GDAXConstants::PRODUCT_ID_ETH_BTC
    );

    protected $ticker = array();

    public function __construct(PublicClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this
            ->setName('order:watch')
            ->addArgument('product-ids', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Products to show ticker for');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getArgument('product-ids')) {
            $this->products = $input->getArgument('product-ids');
        }
        $client = new \WebSocket\Client('wss://ws-feed.gdax.com');
        $client->send(json_encode(array(
            'type' => 'subscribe',
            'product_ids' => $this->products,
            'channels' => array(
                'matches'
            )
        )));
        while(1) {
            $message = $client->receive();
            error_log($message);
            if ($message) {
                $content = json_decode($message);
                if ($content->type == 'match') {
                    error_log($message);
                }
            }
        }
    }
}
