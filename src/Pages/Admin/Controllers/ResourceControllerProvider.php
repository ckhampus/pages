<?php

namespace Pages\Admin\Controllers;

use Pages\Utilities\Inflector;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;

abstract class ResourceControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $entityManager = $app['db.entity_manager'];

        $className = $this->getResourceClass();
        $resource = $this->getNormalizedResourceName();

        $singular = Inflector::singularize($resource);
        $plural = Inflector::pluralize($resource);

        // Convert passed id to an integer.
        $idConverter = function ($id) { return (int)$id; };

        // Convert passed ID to entity.
        $resourceConverter = function ($resource, Request $request) use ($entityManager, $className) {
            $id = $request->get('id');
            return $entityManager->find($className, $id);
        };

        $controllers->match("/{$plural}.{_format}",
                    \Closure::bind(function (Application $app, Request $request) {
                        if ($request->getMethod() === 'POST') {
                            return $this->createAction($app, $request);
                        }

                        return $this->indexAction($app, $request);
                    }, $this))
                    ->method('GET|POST')
                    ->value('_format', 'html')
                    ->bind("{$plural}_path");

        $controllers->match("/{$plural}/{id}.{_format}",
                    \Closure::bind(function (Application $app, Request $request, $resource) {
                        if ($request->getMethod() === 'PUT') {
                            return $this->updateAction($app, $request, $resource);
                        }

                        if ($request->getMethod() === 'DELETE') {
                            return $this->destroyAction($app, $request, $resource);
                        }

                        return $this->showAction($app, $request, $resource);
                    }, $this))
                    ->assert('id', '\d+')
                    ->method('GET|POST|DELETE')
                    ->value('_format', 'html')
                    ->convert('id', $idConverter)
                    ->convert('resource', $resourceConverter)
                    ->bind("{$singular}_path");

        $controllers->get("/{$plural}/new", array($this, 'newAction'))
                    ->bind("new_{$singular}_path");

        $controllers->get("/{$plural}/{id}/edit", array($this, 'editAction'))
                    ->assert('id', '\d+')
                    ->convert('id', $idConverter)
                    ->convert('resource', $resourceConverter)
                    ->bind("edit_{$singular}_path");

        return $controllers;
    }

    /**
     * List all resources.
     *
     * @param  Application     $app The application.
     * @return Response|string The response.
     */
    public function indexAction(Application $app, Request $request)
    {
        return 'Index';
    }

    public function newAction(Application $app, Request $request)
    {
        return 'New';
    }

    /**
     * Create a new resource.
     *
     * @param  Application     $app The application.
     * @return Response|string The response.
     */
    public function createAction(Application $app, Request $request)
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
    public function showAction(Application $app, Request $request, $resource)
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
    public function editAction(Application $app, Request $request, $resource)
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
    public function updateAction(Application $app, Request $request, $resource)
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
    public function destroyAction(Application $app, Request $request, $resource)
    {
        return 'Delete';
    }

    /**
     * Return the fully qualified class name of the resource.
     *
     * @return string The class name.
     */
    abstract public function getResourceClass();

    /**
     * Normalizes the resource class name.
     *
     * @param  string $className The class name.
     * @return string The normalized resource name.
     */
    public function getNormalizedResourceName()
    {
        $className = $this->getResourceClass();

        $resource = substr($className, strrpos($className, '\\') + 1);
        $resource = strtolower($resource);

        return $resource;
    }
}
