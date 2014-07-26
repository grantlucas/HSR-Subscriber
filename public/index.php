<?php

// Autoload all Composer files
require_once __DIR__ . '/../vendor/autoload.php';

// Create Slim app
$app = new \Slim\Slim(array(
  'templates.path' => '../src/templates',
));

// Set app name
$app->setName('HSR-Subscriber');

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
$app->get('/', function() use ($app){\Controller\Subscribe::index();});

// Run Slim app
$app->run();
