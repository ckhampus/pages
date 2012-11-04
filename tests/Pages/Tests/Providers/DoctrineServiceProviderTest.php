<?php

namespace Pages\Tests\Providers;

use Silex\Application;
use Pages\Providers\DoctrineServiceProvider;

class DoctrineServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testProviderRegistration()
    {
        $app = new Application();
        $app->register(new DoctrineServiceProvider(), array(
            'db.options' => array('driver' => 'pdo_sqlite', 'memory' => true),
            'db.proxies' => array(
                'path' => __DIR__.'/Proxies',
                'namespace' => 'Pages\Proxies'
            ),
            'db.entities' => array(
                'driver' => 'yaml',
                'paths' => array(__DIR__.'/entities'),
                'namespace' => 'Pages\Entities'
            )
        ));

        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $app['db.entity_manager']);
        $this->assertInstanceOf('Doctrine\Common\EventManager', $app['db.event_manager']);
        $this->assertInstanceOf('Doctrine\DBAL\Connection', $app['db']);
    }
}