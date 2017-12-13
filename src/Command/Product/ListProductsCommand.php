<?php

namespace BtcTrader\Command\Product;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\PublicClient;

class ListProductsCommand extends AbstractCommand
{
    protected $client;

    public function __construct(PublicClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function configure()
    {
        $this->setName('product:list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->client->getProducts();
        $this->climate->table(array_map(function($product) {
            return array(
                'Id' => $product->getId(),
                'Base Currency' => $product->getBaseCurrency(),
                'Quote Currency' => $product->getQuoteCurrency(),
                'Base Minimum Size' => $product->getBaseMinSize(),
                'Base Maximum Size' => $product->getBaseMaxSize(),
                'Quote Increment' => $product->getQuoteIncrement(),
                'Display Name' => $product->getDisplayName(),
                'Margin Enabled' => ($product->isMarginEnabled() ? 'true' : 'false'),
                'Status' => $product->getStatus()
            );
        }, $products));
    }
}
