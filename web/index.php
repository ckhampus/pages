<?php

require __DIR__.'/../vendor/autoload.php';

use Pages\Application;

$app = new Application();
$app['debug'] = true;
$app->run();