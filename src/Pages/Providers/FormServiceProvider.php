<?php

namespace Pages\Providers;

use Silex\Application;
use Silex\Provider\FormServiceProvider as BaseFormServiceProvider;

use Pages\Doctrine\ManagerRegistry;

/**
 * Extended Form component provider which
 * adds support for Doctrine entity forms.
 */
class FormServiceProvider extends BaseFormServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);

        $app['form.extensions']->share($app->extend('form.extensions', function ($extensions, $app) {
            if (isset($app['db'])) {
                $registry = new ManagerRegistry($app['db'], $app['db.entity_manager']);
                $extensions[] = new \Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension($registry);
            }

            return $extensions;
        }));
    }
}