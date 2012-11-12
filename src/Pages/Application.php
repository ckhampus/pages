<?php

namespace Pages;

use Silex\Application as BaseApplication;

use Pages\Admin\Controllers\ColumnControllerProvider;
use Pages\Admin\Controllers\LayoutControllerProvider;
use Pages\Admin\Controllers\PageControllerProvider;
use Pages\Admin\Controllers\UserControllerProvider;
use Pages\Providers\DoctrineServiceProvider;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct();

        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver' => 'pdo_sqlite',
                'path' => __DIR__.'/../../db/app.sqlite'
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

        $this->mount('/admin', new ColumnControllerProvider());
        $this->mount('/admin', new LayoutControllerProvider());
        $this->mount('/admin', new PageControllerProvider());
        $this->mount('/admin', new UserControllerProvider());
    }
}
