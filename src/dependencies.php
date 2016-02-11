<?php
// DIC configuration

$container = $app->getContainer();

// Register provider
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// view renderer
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates/', [
        'cache' => false,
        'debug'=>true
    ]);
    
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri(),
        new \Twig_Extension_Debug()
    ));

    $view->addExtension(new Twig_Extension_Debug());
    //$view->enableDebug();

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};


