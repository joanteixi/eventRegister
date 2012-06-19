<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * @var Silex\Application
 */
$app = new Application();

/**
 * Configuration
 */
$app['debug'] = true;
$app['mail.from'] = 'info@eltercer.net';
$app['mail.to'] = 'joan@laiogurtera.com';


/**
 * Providers
 */
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.transport'] = \Swift_SendmailTransport::newInstance();
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => array(
        __DIR__ . '/../src/Event/Resources/views',
    ),
    'twig.options' => array(
        'cache' => __DIR__ . '/../data/cache/twig',
    ),
));



return $app;