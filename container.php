<?php

use \Symfony\Component\DependencyInjection\Reference;
use \Symfony\Component\DependencyInjection\Parameter;

$container->setParameter('debug', false);
$container->setParameter('gdax.api_key', getenv("API_KEY"));
$container->setParameter('gdax.api_secret', getenv("API_SECRET"));
$container->setParameter('gdax.passphrase', getenv("API_PASSPHRASE"));
$container->setParameter('gdax.api_url', \GDAX\Utilities\GDAXConstants::GDAX_API_URL);

$container->register('gdax.public_client', \GDAX\Clients\PublicClient::class)
    ->addMethodCall('setBaseURL', ['%gdax.api_url%']);
$container->register('gdax.authenticated_client', \GDAX\Clients\AuthenticatedClient::class)
    ->setArguments([
        '%gdax.api_key%',
        '%gdax.api_secret%',
        '%gdax.passphrase%'
    ])
    ->addMethodCall('setBaseURL', ['%gdax.api_url%']);

/**
 * Account Commands
 */
$container->register('console.command.list_accounts', \BtcTrader\Command\Account\ListAccountsCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.show_account', \BtcTrader\Command\Account\ShowAccountCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.account_history', \BtcTrader\Command\Account\AccountHistoryCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.account_holds', \BtcTrader\Command\Account\AccountHoldsCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.coinbase_accounts', \BtcTrader\Command\Account\CoinbaseAccountsCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);

/**
 * Funding Commands
 */
$container->register('console.command.list_fundings', \BtcTrader\Command\Funding\ListFundingsCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
/**
 * Payment Method Commands
 */
 $container->register('console.command.list_methods', \BtcTrader\Command\PaymentMethod\ListMethodsCommand::class)
     ->setArguments([new Reference('gdax.authenticated_client')]);
/**
 * Action Commands
 */
$container->register('console.command.deposit', \BtcTrader\Command\DepositCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.position', \BtcTrader\Command\PositionCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.withdraw', \BtcTrader\Command\WithdrawCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);

/**
 * Order Commands
 */
$container->register('console.command.cancel_order', \BtcTrader\Command\Order\CancelOrderCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.list_orders', \BtcTrader\Command\Order\ListOrdersCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.watch_orders', \BtcTrader\Command\Order\OrderWatchCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
$container->register('console.command.cancel_all', \BtcTrader\Command\Order\CancelAllCommand::class)
    ->setArguments([new Reference('gdax.authenticated_client')]);
/**
 * Product Commands
 */
$container->register('console.command.list_products', \BtcTrader\Command\Product\ListProductsCommand::class)
    ->setArguments([new Reference('gdax.public_client')]);
$container->register('console.command.product_ticker', \BtcTrader\Command\Product\ProductTickerCommand::class)
    ->setArguments([new Reference('gdax.public_client')]);
/**
 * Reporting commands
 */
 $container->register('console.command.historic_rates', \BtcTrader\Command\Report\HistoricRateCommand::class)
     ->setArguments([new Reference('gdax.public_client')]);
 $container->register('console.command.daily_rates', \BtcTrader\Command\Report\DailyStatsCommand::class)
     ->setArguments([new Reference('gdax.public_client')]);
 $container->register('console.command.dataset', \BtcTrader\Command\Report\DatasetCommand::class)
     ->setArguments([new Reference('gdax.public_client')]);
/**
 * Register our Console Application
 */
$container->register('console.application', \BtcTrader\Application::class)
    ->addMethodCall('add', [new Reference('console.command.list_accounts')])
    ->addMethodCall('add', [new Reference('console.command.coinbase_accounts')])
    ->addMethodCall('add', [new Reference('console.command.account_history')])
    ->addMethodCall('add', [new Reference('console.command.show_account')])
    ->addMethodCall('add', [new Reference('console.command.account_holds')])
    ->addMethodCall('add', [new Reference('console.command.list_fundings')])
    ->addMethodCall('add', [new Reference('console.command.list_methods')])
    ->addMethodCall('add', [new Reference('console.command.deposit')])
    ->addMethodCall('add', [new Reference('console.command.position')])
    ->addMethodCall('add', [new Reference('console.command.withdraw')])
    ->addMethodCall('add', [new Reference('console.command.cancel_order')])
    ->addMethodCall('add', [new Reference('console.command.cancel_all')])
    ->addMethodCall('add', [new Reference('console.command.list_orders')])
    ->addMethodCall('add', [new Reference('console.command.watch_orders')])
    ->addMethodCall('add', [new Reference('console.command.list_products')])
    ->addMethodCall('add', [new Reference('console.command.product_ticker')])
    ->addMethodCall('add', [new Reference('console.command.historic_rates')])
    ->addMethodCall('add', [new Reference('console.command.daily_rates')])
    ->addMethodCall('add', [new Reference('console.command.dataset')])
;
