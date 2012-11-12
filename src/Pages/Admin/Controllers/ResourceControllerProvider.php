<?php

namespace Pages\Admin\Controllers;

use Pages\Utilities\Inflector;

use Silex\Application;
use Silex\ControllerProviderInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ResourceControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $className = $this->getResourceClass();
        $resource = $this->getNormalizedResourceName();

        $singular = Inflector::singularize($resource);
        $plural = Inflector::pluralize($resource);

        // Convert passed id to an integer.
        $idConverter = function ($id) { return (int) $id; };

        // Convert passed ID to entity.
        $resourceConverter = function ($resource, Request $request) use ($app, $className) {
            return $app['db.entity_manager']->find($className, $request->get('id'));
        };

        $controllers = $app['controllers_factory'];

        $controllers->match("/{$plural}.{_format}",
                    \Closure::bind(function (Application $app, Request $request) {
                        if ($request->getMethod() === 'POST') {
                            return $this->createAction($app, $request);
                        }

                        return $this->indexAction($app, $request);
                    }, $this))
                    ->assert('_format', 'xml|json|html')
                    ->method('GET|POST')
                    ->value('_format', 'json')
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
                    ->assert('_format', 'xml|json|html')
                    ->method('GET|PUT|DELETE')
                    ->value('_format', 'json')
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
     * @param  Application     $app     The application.
     * @param  Request         $request The request.
     * @return Response|string The response.
     */
    public function indexAction(Application $app, Request $request)
    {
        $em = $app['db.entity_manager'];

        $resources = $em->getRepository($this->getResourceClass())->findAll();
        $format = $request->getRequestFormat();

        return new Response($app['serializer']->serialize($resources, $format), 200, [
            'Content-Type' => $request->getMimeType($format)
        ]);
    }

    public function newAction(Application $app, Request $request)
    {
        return 'New';
    }

    /**
     * Create a new resource.
     *
     * @param  Application     $app     The application.
     * @param  Request         $request The request.
     * @return Response|string The response.
     */
    public function createAction(Application $app, Request $request)
    {
        $em = $app['db.entity_manager'];

        return 'Create';
    }

    /**
     * Show a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  Request         $request  The request.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function showAction(Application $app, Request $request, $resource)
    {
        $em = $app['db.entity_manager'];

        if ($resource === null) {
            return $app->abort(404, "Resource does not exist");
        }

        return 'Show';
    }

    /**
     * Edit a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  Request         $request  The request.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function editAction(Application $app, Request $request, $resource)
    {
        $em = $app['db.entity_manager'];

        return 'Edit';
    }

    /**
     * Update a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  Request         $request  The request.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function updateAction(Application $app, Request $request, $resource)
    {
        $em = $app['db.entity_manager'];

        return 'Update';
    }

    /**
     * Delete a single resource by id.
     *
     * @param  Application     $app      The application.
     * @param  Request         $request  The request.
     * @param  object          $resource The resource.
     * @return Response|string The response.
     */
    public function destroyAction(Application $app, Request $request, $resource)
    {
        $em = $app['db.entity_manager'];

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
