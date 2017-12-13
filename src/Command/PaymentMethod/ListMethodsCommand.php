<?php

namespace BtcTrader\Command\PaymentMethod;

use BtcTrader\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use GDAX\Clients\AuthenticatedClient;
use GDAX\Types\Request\Authenticated\Funding;
use GDAX\Utilities\GDAXConstants;

class ListMethodsCommand extends AbstractCommand
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
            ->setName('method:list')
            ->addOption('--status', 's', InputOption::VALUE_OPTIONAL, 'Status of fundings to fetch', GDAXConstants::FUNDING_STATUS_SETTLED);
    }

    // Add CLI pagination
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $climate = $this->getClimate();
        $methods = $this->client->getPaymentMethods();
        foreach ($methods as $method) {
            $climate->flank($method->getId(), '####');
            $climate->out('Name: '.$method->getName());
            $climate->out('Currency: '.$method->getCurrency());
            $climate->out(PHP_EOL.'Permissions'.PHP_EOL);

            $climate->out('Primary Buy: '.($method->isPrimaryBuy() ? 'true' : 'false'));
            $climate->out('Primary Sell: '.($method->isPrimarySell() ? 'true' : 'false'));
            $climate->out('Allow Buy: '.($method->isAllowBuy() ? 'true' : 'false'));
            $climate->out('Allow Sell: '.($method->isAllowSell() ? 'true' : 'false'));
            $climate->out('Allow Withdraw: '.($method->isAllowWithdraw() ? 'true' : 'false'));
            $climate->out('Allow Sell: '.($method->isAllowSell() ? 'true' : 'false'));
            $climate->out(PHP_EOL.'Limits'.PHP_EOL);

            $limits = [];
            foreach ($method->getLimits() as $key => $value) {
                $value = $value[0];
                $limits[] = array(
                    'Type' => $key,
                    'Time Period (d)' => $value['period_in_days'],
                    'Total' => $value['total']['amount'].' '.$value['total']['currency'],
                    'Remaining' => $value['remaining']['amount'].' '.$value['remaining']['currency']
                );
            }
            $climate->table($limits);
            $climate->out(PHP_EOL);
        }

        $climate->out(PHP_EOL);
    }
}
