<?php

namespace BtcTrader\Command;

use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    protected $climate;

    public function __construct()
    {
        $this->climate = new \League\CLImate\CLImate;
        parent::__construct();
    }

    public function getClimate()
    {
        return $this->climate;
    }
}
