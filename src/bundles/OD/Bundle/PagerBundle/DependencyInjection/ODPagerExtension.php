<?php

namespace bundles\OD\Bundle\PagerBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ODPagerExtension extends Extension {

    public function load(array $configs, ContainerBuilder $container) {

        $processor = new Processor();
        $config = $processor->process($this->getConfigTree(), $configs);

        $container->setParameter('od_pager.page_in_range_count', $config['page_in_range_count']);
        $container->setParameter('od_pager.page_size', $config['page_size']);
    }

    public function getXsdValidationBasePath() {
        return __DIR__ . '/../Resources/config/';
    }

    public function getNamespace() {
        return 'http://www.example.com/symfony/schema/';
    }

    public function getAlias() {
        return 'od_pager';
    }

    private function getConfigTree() {
        $tb = new TreeBuilder();

        return $tb
                ->root('od_pager')
                ->children()
                ->scalarNode('page_size')->defaultValue(10)->end()
                ->scalarNode('page_in_range_count')->defaultValue(5)->end()
                ->end()
                ->end()
                ->buildTree();
    }

}