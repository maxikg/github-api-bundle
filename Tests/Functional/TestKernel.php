<?php

namespace Maxikg\GithubApiBundle\Tests\Functional;

use Maxikg\GithubApiBundle\GithubApiBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function getRootDir()
    {
        return __DIR__ . '/var';
    }

    public function registerBundles()
    {
        return array(
            new GithubApiBundle()
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}