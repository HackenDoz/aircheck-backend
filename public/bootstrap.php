<?php

require __DIR__ . '/../vendor/autoload.php';

$config = include 'config.php';
$injector = include 'dependencies.php';

$api = new Framework\API($config, $injector);
$api->route();