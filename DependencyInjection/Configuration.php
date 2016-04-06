<?php

namespace Maxikg\GithubApiBundle\DependencyInjection;

use Github\Client;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const AUTHENTICATION_DISABLED = 'none';

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('github_api');

        $rootNode
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->scalarNode('service')->defaultValue('github.http.cache')->end()
                    ->end()
                ->end()
                ->arrayNode('client')->end()
                ->scalarNode('enterprise_url')->defaultNull()->end()
                ->arrayNode('authentication')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('type')
                            ->values(self::getValidAuthMethods())
                            ->defaultValue(self::AUTHENTICATION_DISABLED)
                        ->end()
                        ->scalarNode('token')->defaultNull()->end()
                        ->scalarNode('client_id')->defaultNull()->end()
                        ->scalarNode('client_secret')->defaultNull()->end()
                        ->scalarNode('username')->defaultNull()->end()
                        ->scalarNode('password')->defaultNull()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    private static function getValidAuthMethods()
    {
        return [
            Client::AUTH_HTTP_PASSWORD,
            Client::AUTH_HTTP_TOKEN,
            Client::AUTH_URL_CLIENT_ID,
            Client::AUTH_URL_TOKEN,
            self::AUTHENTICATION_DISABLED
        ];
    }
}