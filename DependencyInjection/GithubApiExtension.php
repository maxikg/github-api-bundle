<?php

namespace Maxikg\GithubApiBundle\DependencyInjection;

use Github\Client;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class GithubApiExtension extends Extension
{
    const CACHED_CLIENT_CLASS = 'Github\HttpClient\CachedHttpClient';

    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $clientDefinition = $container->findDefinition('github.http.client');

        // Configure cache
        if (true === $config['cache']['enabled']) {
            $clientDefinition->setClass(self::CACHED_CLIENT_CLASS);
            $clientDefinition->addMethodCall('setCache', [new Reference($config['cache']['service'])]);
        }

        // Configure client options
        if (isset($config['client'])) {
            foreach ($config['client'] as $key => $value) {
                $clientDefinition->addMethodCall('setOption', [$key, $value]);
            }
        }

        // Configure enterprise url
        if ($config['enterprise_url']) {
            $clientDefinition->addMethodCall('setEnterpriseUrl', $config['enterprise_url']);
        }

        // Configure authentication
        $type = $config['authentication']['type'];
        if (Configuration::AUTHENTICATION_DISABLED !== $type) {
            $tokenOrLogin = null;
            $password = null;

            switch ($type) {
                case Client::AUTH_HTTP_TOKEN:
                case Client::AUTH_URL_TOKEN:
                    $tokenOrLogin = $config['token'];
                    break;
                case Client::AUTH_URL_CLIENT_ID:
                    $tokenOrLogin = $config['client_id'];
                    $password = $config['client_secret'];
                    break;
                case Client::AUTH_HTTP_PASSWORD:
                    $tokenOrLogin = $config['username'];
                    $password = $config['password'];
            }

            $clientDefinition->addMethodCall('authenticate', [$tokenOrLogin, $password, $type]);
        }
    }
}