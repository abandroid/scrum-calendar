<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('endroid_calendar_scrum')
                ->children()
                    ->arrayNode('sprints')
                        ->useAttributeAsKey('test')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('url')->isRequired()->end()
                                ->scalarNode('start')->isRequired()->end()
                                ->scalarNode('interval')->isRequired()->end()
                                ->booleanNode('repeat')->defaultValue(false)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
