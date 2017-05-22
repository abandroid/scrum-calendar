<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum\Bundle\CalendarScrumBundle\DependencyInjection;

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
                    ->arrayNode('sprint_definitions')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('label')->isRequired()->end()
                                ->scalarNode('url')->isRequired()->end()
                                ->scalarNode('date_start')->isRequired()->end()
                                ->scalarNode('date_interval')->isRequired()->end()
                                ->booleanNode('repeat')->defaultValue(false)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
        ;

        return $treeBuilder;
    }
}
