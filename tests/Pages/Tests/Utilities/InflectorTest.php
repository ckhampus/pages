<?php

namespace Pages\Tests\Utilities;

use Pages\Utilities\Inflector;

class InflectorTest extends \PHPUnit_Framework_TestCase
{
    public function dataWords()
    {
        return [
            ['post', 'posts'],
            ['page', 'pages'],
            ['type', 'types'],
            ['movie', 'movies'],
            ['plugin', 'plugins'],
            ['theme', 'themes'],
            ['menu', 'menus'],
            ['product', 'products'],
            ['place', 'places'],
            ['designer', 'designers'],
            ['search', 'searches'],
            ['tweet', 'tweets'],
            ['resource', 'resources'],
            ['information', 'information'],
            ['venue', 'venues'],
            ['order', 'orders'],
            ['line', 'lines'],
            ['order_line', 'order_lines'],
            ['post_type', 'post_types'],
            ['setting', 'settings'],
            ['table', 'tables'],
            ['row', 'rows'],
            ['computer', 'computers'],
            ['note', 'notes'],
            ['format', 'formats'],
            ['feed', 'feeds']
        ];
    }

    /**
     * @dataProvider dataWords
     */
    public function testPluralization($singular, $plural)
    {
        $this->assertEquals($plural, Inflector::pluralize($singular));
    }

    public function testPluralizeIf()
    {
        $this->assertEquals('1 movie', Inflector::pluralizeIf(1, 'movie'));
        $this->assertEquals('2 movies', Inflector::pluralizeIf(2, 'movie'));
    }

    /**
     * @dataProvider dataWords
     */
    public function testSingularization($singular, $plural)
    {
        $this->assertEquals($singular, Inflector::singularize($plural));
    }

    /**
     * @dataProvider dataWords
     */
    public function testPluralizationOfAlreadyPluralWords($singular, $plural)
    {
        $this->assertEquals($plural, Inflector::pluralize($plural));
    }

    /**
     * @dataProvider dataWords
     */
    public function testSingularizationOfAlreadySingulWords($singular, $plural)
    {
        $this->assertEquals($singular, Inflector::singularize($singular));
    }

    /**
     * @dataProvider dataWords
     */
    public function testIsPlural($singular, $plural)
    {
        $this->assertTrue(Inflector::isPlural($plural));
    }

    /**
     * @dataProvider dataWords
     */
    public function testIsSingular($singular, $plural)
    {
        $this->assertTrue(Inflector::isSingular($singular));
    }

    public function testUnderscore()
    {
        $this->assertEquals('hello_world', Inflector::underscore('Hello World'));
        $this->assertEquals('ssl_error', Inflector::underscore('SSLError'));
    }

    public function testTableize()
    {
        $this->assertEquals('hello_worlds', Inflector::tableize('Hello World'));
        $this->assertEquals('ssl_errors', Inflector::tableize('SSLError'));
    }
}
