<?php
error_reporting(E_ALL);
define('ROOT_DIR', realpath(__DIR__ . '/../'));
require_once ROOT_DIR . '/silex.phar';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
));

$app->match('/', function () use($app) {
    return $app['twig']->render('home.twig');
  });

$app->match('/humans.txt', function () use($app) {
    return $app['twig']->render('robots.twig');
  });

$app->error(function ($e) use ($app) {
    if ($e instanceof NotFoundHttpException)
      return new Response('', 302, array('Location' => '/'));
    return new Response($app['twig']->render('home.twig', array('e' => $e)), 500);
  });

$app->run();
