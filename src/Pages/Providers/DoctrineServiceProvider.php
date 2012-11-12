<?php

namespace Pages\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\StaticPHPDriver;

/**
 * This service provider adds support for the Doctrine ORM.
 */
class DoctrineServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['db.default_options'] = array(
            'driver'   => 'pdo_mysql',
            'dbname'   => null,
            'host'     => 'localhost',
            'user'     => 'root',
            'password' => null,
        );

        $app['db.config'] = $app->share(function () use ($app) {
            $config = null;

            $cache = isset($app['db.cache']) ? $app['db.cache'] : null;

            if (isset($app['db.entities']) && !empty($app['db.entities'])) {
                switch ($app['db.entities']['driver']) {
                    case 'yaml':
                        $config = Setup::createYAMLMetadataConfiguration($app['db.entities']['paths'], $app['debug']);
                        break;
                    case 'xml':
                        $config = Setup::createXMLMetadataConfiguration($app['db.entities']['paths'], $app['debug']);
                        break;
                    case 'php':
                        $config = Setup::createConfiguration($app['debug']);
                        $config->setMetadataDriverImpl(new StaticPHPDriver($app['db.entities']['paths']));
                        break;
                    case 'annotation':
                    default:
                        $config = Setup::createAnnotationMetadataConfiguration($app['db.entities']['paths'], $app['debug']);
                        break;
                }
            }

            return $config;
        });

        $app['db.entity_manager'] = $app->share(function () use ($app) {
            if (isset($app['db.options'])) {
                return EntityManager::create($app['db.options'], $app['db.config']);
            } else {
                throw new \Exception('No options defined.');
            }
        });

        $app['db.event_manager'] = $app->share(function () use ($app) {
            return $app['db.entity_manager']->getEventManager();
        });

        $app['db'] = $app->share(function () use ($app) {
            return $app['db.entity_manager']->getConnection();
        });
    }

    public function boot(Application $app)
    {
    }
}
