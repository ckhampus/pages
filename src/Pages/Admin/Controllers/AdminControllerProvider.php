<?php

namespace Pages\Admin\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class AdminControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app->mount('/', new PageControllerProvider());
    }
}
