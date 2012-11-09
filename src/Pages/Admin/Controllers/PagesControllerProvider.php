<?php

namespace Pages\Admin\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class PagesControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $converter = function ($id, Request $request) use ($app) {
            
        };

        $controllers->get('/pages', array($this, 'indexAction'));

        $controllers->get('/pages/new', array($this, 'newAction'));

        $controllers->post('/pages', array($this, 'createAction'));

        $controllers->get('/pages/{id}', array($this, 'showAction'))
                    ->assert('id', '\d+')
                    ->convert('page', $converter);

        $controllers->get('/pages/{id}/edit', array($this, 'editAction'))
                    ->assert('id', '\d+')
                    ->convert('page', $converter);

        $controllers->put('/pages/{id}', array($this, 'updateAction'))
                    ->assert('id', '\d+')
                    ->convert('page', $converter);

        $controllers->delete('/pages/{id}', array($this, 'destroyAction'))
                    ->assert('id', '\d+')
                    ->convert('page', $converter);

        return $controllers;
    }

    /**
     * List all pages.
     * @param  Application $app The application.
     * @return Response|string           The response.
     */
    public function indexAction(Application $app)
    {
        return 'Index';
    }

    public function newAction(Application $app)
    {
        return 'New';
    }

    /**
     * Create a new page.
     *
     * @param  Application $app The application.
     * @return Response|string           The response.
     */
    public function createAction(Application $app)
    {
        return 'Create';
    }

    /**
     * Show a single page by id.
     *
     * @param  Application $app The application.
     * @param  Page      $page  The page.
     * @return Response|string           The response.
     */
    public function showAction(Application $app, Page $page)
    {
        return 'Show';
    }

    public function editAction(Application $app, Page $page)
    {
        return 'Edit';
    }

    public function updateAction(Application $app, Page $page)
    {
        return 'Update';
    }

    public function destroyAction(Application $app, Page $page)
    {
        return 'Destroy';
    }
}