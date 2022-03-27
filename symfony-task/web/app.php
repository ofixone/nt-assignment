<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

umask(0000);

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

if ($_ENV['APP_ENV']) {
    Debug::enable();
}

$kernel = new AppKernel($_ENV['APP_ENV'], false);

$request = Request::createFromGlobals();
/** @noinspection PhpUnhandledExceptionInspection */
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
