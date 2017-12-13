#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;

$container = new ContainerBuilder();
$loader = new PhpFileLoader($container, new FileLocator(__DIR__));
$loader->load('container.php');
if (file_exists('container.env.php')) {
    $loader->load('container.env.php');
}
$container->get('console.application')->run();
