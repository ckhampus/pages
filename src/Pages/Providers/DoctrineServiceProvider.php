<?php

namespace Pages\Providers;

use Silex\Application;
use Silex\ServiceProviderInterface;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class DoctrineServiceProvider extends ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['db.config'] = $app->share(function () use ($app) {
            $config = null;

            if (isset($app['db.metadata']) && !empty($app['db.metadata'])) {
                switch ($app['db.metadata']['driver']) {
                    case 'yaml':
                        $config = Setup::createYAMLMetadataConfiguration($app['db.metadata']['paths'], $app['debug'], $app['db.cache']);
                        break;
                    case 'xml':
                        $config = Setup::createXMLMetadataConfiguration($app['db.metadata']['paths'], $app['debug'], $app['db.cache']);
                        break;
                    case 'annotation':
                    default:
                        $config = Setup::createAnnotationMetadataConfiguration($app['db.metadata']['paths'], $app['debug'], $app['db.cache']);
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