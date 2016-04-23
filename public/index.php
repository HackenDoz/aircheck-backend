<?php

require __DIR__ . '/bootstrap.php';

$api = new Framework\API($config, $injector);
$api->route();