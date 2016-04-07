<?php

namespace Maxikg\GithubApiBundle\Tests\Functional;

use Symfony\Component\HttpKernel\Kernel;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Kernel
     */
    private $kernel;

    public function setUp()
    {
        $this->kernel = new TestKernel('test', false);
        $this->kernel->boot();
    }

    /**
     * @test
     * @functional
     */
    public function testServiceAvailability()
    {
        $this->assertInstanceOf('Github\Client', $this->kernel->getContainer()->get('github.client'));
        $this->assertInstanceOf('Github\HttpClient\HttpClient', $this->kernel->getContainer()->get('github.http.client'));
        $this->assertInstanceOf('Github\HttpClient\Cache\FilesystemCache', $this->kernel->getContainer()->get('github.http.cache'));
    }
}