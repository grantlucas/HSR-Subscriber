<?php

// Autoload all Composer files
require_once __DIR__ . '/../vendor/autoload.php';

// Create Slim app
$app = new \Slim\Slim(array(
  'templates.path' => '../src/templates',
));

// Set app name
$app->setName('HSR-Subscriber');

// Read in config file
$config = parse_ini_file('../config.ini', true);
$app->user_config = $config;

// Prepare view using Twig
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset'          => 'utf-8',
    'cache'            => realpath('../templates/cache'),
    'auto_reload'      => true,
    'strict_variables' => false,
    'autoescape'       => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Routes
$app->map('/subscribe', function() use ($app){\Controller\Subscribe::index();})
  ->name('subscribe')
  ->via('GET', 'POST');

$app->get('/subscribe/update', function() use ($app){\Controller\Subscribe::update();});
$app->get('/subscribe/start', function() use ($app){\Controller\Subscribe::start();});

// Run Slim app
$app->run();
