<?php

namespace Pages\Tests\Admin\Controllers;

use Pages\Application;

use Silex\WebTestCase;

class ControllerProviderTest extends WebTestCase
{
    public function createApplication()
    {
        $app = new Application();
        $app['environment'] = 'test';
        unset($app['exception_handler']);

        return $app;
    }

    public function dataResources()
    {
        return [
            ['columns'],
            ['layouts'],
            ['pages'],
            ['users']
        ];
    }

    /**
     * @dataProvider dataResources
     */
    public function testIndexAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', "/admin/{$resource}");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testNewAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', "/admin/{$resource}/new");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testCreateAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('POST', "/admin/{$resource}");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testShowAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', "/admin/{$resource}/1");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testEditAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', "/admin/{$resource}/1/edit");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testUpdateAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('PUT', "/admin/{$resource}/1");

        $this->assertTrue($client->getResponse()->isOk());
    }

    /**
     * @dataProvider dataResources
     */
    public function testDestroyAction($resource)
    {
        $client = $this->createClient();
        $crawler = $client->request('DELETE', "/admin/{$resource}/1");

        $this->assertTrue($client->getResponse()->isOk());
    }
}
