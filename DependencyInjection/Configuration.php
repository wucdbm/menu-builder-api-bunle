<?php

namespace Wucdbm\Bundle\MenuBuilderApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    public function getConfigTreeBuilder() {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wucdbm_menu_builder_api');

        $rootNode
            ->children()
                ->scalarNode('secret')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }

}