<?php

define('ROOT_DIR', realpath(__DIR__ . '/../'));
require_once ROOT_DIR . '/silex.phar';

$app = new Silex\Application;

use Silex\Extension\TwigExtension;

$app->register(new TwigExtension(), array(
    'twig.path'       => ROOT_DIR.'/views'
));

$app->match('/', function () use($app) {
  return $app['twig']->render('home.html');
});

$app->error(function ($e) use ($app){
  if ($e instanceof NotFoundHttpException) {
    return new Response('', 302, array('Location' => '/'));
  }
  return new Response($app['twig']->render('home.html', array('e' => $e)), 500);
});

$app->run();