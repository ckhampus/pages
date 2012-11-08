<?php

namespace Pages\Admin\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class PagesControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/pages', array($this, 'indexAction'));
        $controllers->get('/pages/new', array($this, 'newAction'));
        $controllers->post('/pages', array($this, 'createAction'));
        $controllers->get('/pages/{id}', array($this, 'showAction'));
        $controllers->get('/pages/{id}/edit', array($this, 'editAction'));
        $controllers->put('/pages/{id}', array($this, 'updateAction'));
        $controllers->delete('/pages/{id}', array($this, 'destroyAction'));

        return $controllers;
    }

    public function indexAction(Application $app)
    {
        return 'Index';
    }

    public function newAction(Application $app)
    {
        return 'New';
    }

    public function createAction(Application $app)
    {
        return 'Create';
    }

    public function showAction(Application $app, $id)
    {
        return 'Show';
    }

    public function editAction(Application $app, $id)
    {
        return 'Edit';
    }

    public function updateAction(Application $app, $id)
    {
        return 'Update';
    }

    public function destroyAction(Application $app, $id)
    {
        return 'Destroy';
    }
}