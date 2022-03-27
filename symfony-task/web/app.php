<?php

require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

umask(0000);

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$isDebugEnabled = filter_var($_ENV['APP_DEBUG'], FILTER_VALIDATE_BOOL);
if ($isDebugEnabled) {
    Debug::enable();
}

$kernel = new AppKernel($_ENV['APP_ENV'], $isDebugEnabled);

$request = Request::createFromGlobals();
/** @noinspection PhpUnhandledExceptionInspection */
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
