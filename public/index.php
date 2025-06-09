<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use App\controllers\HomeController;
use App\controllers\PaymentController;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';


$dotenv = new Dotenv();
$env = __DIR__ . '/../.env';
$localEnv = __DIR__ . '/../.env.local';
if (file_exists($localEnv)) {
    $dotenv->load($localEnv);
} elseif (file_exists($env)) {
    $dotenv->load($env);
}

try {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(require __DIR__ . "/../config/container.php");
    $container = $builder->build();
    $app = AppFactory::createFromContainer($container);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    $app->addErrorMiddleware(true, true, true);

    $app->get("/", [HomeController::class, 'index'])->setName('home');
    $app->post("/donate", [PaymentController::class, 'donate'])->setName('donate');
    $app->get("/payment/success", [PaymentController::class, 'success'])->setName('payment.success');
    $app->get("/payment/error", [PaymentController::class, 'error'])->setName('payment.error');

    $app->run();
} catch (Exception $e) {
}


