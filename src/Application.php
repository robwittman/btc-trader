<?php

namespace BtcTrader;

use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    public function __construct($version = '0.0.0')
    {
        parent::__construct('BtcTrader -- '.$version);
    }
}
