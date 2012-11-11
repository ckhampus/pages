<?php

namespace Pages\Admin\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

abstract class ResourceControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $entityManager = $app['db.entity_manager'];

        $class = $this->getResourceClass();
        $metadata = $entityManager->getClassMetadata($class);
        $resource = $metadata->name;

        $converter = function ($id, Request $request) use ($entityManager, $class) {
            return $entityManager->find($class, $id);
        };

        $controllers->get("/{$resource}", array($this, 'indexAction'));

        $controllers->get("/{$resource}/new", array($this, 'newAction'));

        $controllers->post("/{$resource}", array($this, 'createAction'));

        $controllers->get("/{$resource}/{id}", array($this, 'showAction'))
                    ->assert('id', '\d+')
                    ->convert('resource', $converter);

        $controllers->get("/{$resource}/{id}/edit", array($this, 'editAction'))
                    ->assert('id', '\d+')
                    ->convert('resource', $converter);

        $controllers->put("/{$resource}/{id}", array($this, 'updateAction'))
                    ->assert('id', '\d+')
                    ->convert('resource', $converter);

        $controllers->delete("/{$resource}/{id}", array($this, 'deleteAction'))
                    ->assert('id', '\d+')
                    ->convert('resource', $converter);

        return $controllers;
    }

    /**
     * List all resources.
     *
     * @param  Application     $app The application.
     * @return Response|string The response.
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
     * Create a new resource.
     *
     * @param  Application     $app The application.
     * @return Response|string The response.
     */
    public function createAction(Application $app)
    {
        return 'Create';
    }

    /**
     * Show a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function showAction(Application $app, $resource)
    {
        return 'Show';
    }

    /**
     * Edit a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function editAction(Application $app, $resource)
    {
        return 'Edit';
    }

    /**
     * Update a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function updateAction(Application $app, $resource)
    {
        return 'Update';
    }

    /**
     * Delete a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function deleteAction(Application $app, $resource)
    {
        return 'Delete';
    }

    abstract public function getResourceClass();
}
