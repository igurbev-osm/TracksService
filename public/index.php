<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Slim\Factory\AppFactory;
use DI\Container;
use org\osmap\Settings;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = Settings::load(__DIR__ . '/../appsettings.json');
$container->set('settings', $settings);

(require __DIR__ . '/../src/org/osmap/dependencies.php')($container);

AppFactory::setContainer($container);

$app = AppFactory::create();
(require __DIR__ . '/../src/org/osmap/routes.php')($app);
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
});
$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});
$app->run();
