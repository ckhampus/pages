<?php

namespace Pages;

use Silex\Application as BaseApplication;

use Pages\Admin\Controllers\AdminControllerProvider;
use Pages\Provider\DoctrineServiceProvider;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct();

        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_sqlite'
            ),
            'db.proxies' => array(
                'path' => __DIR__.'/Proxies',
                'namespace' => 'Pages\Proxies'
            ),
            'db.entities' => array(
                'driver' => 'php',
                'paths' => array(__DIR__.'/Entities'),
                'namespace' => 'Pages\Entities'
            )
        ));

        $this->mount('/admin', new AdminControllerProvider());
    }
}