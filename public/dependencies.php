<?php

$injector = new Auryn\Injector;

$injector->share('Symfony\Component\HttpFoundation\Request');
$injector->define('Symfony\Component\HttpFoundation\Request', [
    ':query' => $_GET,
    ':request' => $_POST,
    ':attributes' => array(),
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->share('PDO');
$injector->define('PDO', [
    ':dsn' => 'mysql:dbname=' . $config['db']['dbname'] . ';host=' . $config['db']['host'] . ';port=' . $config['db']['port'],
    ':username' => $config['db']['user'],
    ':passwd' => $config['db']['pass']
]);

return $injector;