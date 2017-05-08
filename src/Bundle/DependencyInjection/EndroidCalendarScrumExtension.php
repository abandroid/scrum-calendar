<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum\Bundle\DependencyInjection;

use DateInterval;
use DateTime;
use Endroid\CalendarScrum\SprintDefinition;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class EndroidCalendarScrumExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $sprintManagerDefinition = $container->getDefinition('endroid_calendar_scrum.sprint_definition_registry');

        foreach ($config['sprint_definitions'] as $name => $sprint) {
            $dateStartDefinition = new Definition(DateTime::class);
            $dateStartDefinition->addArgument($sprint['date_start']);
            $dateIntervalDefinition = new Definition(DateInterval::class);
            $dateIntervalDefinition->addArgument($sprint['date_interval']);
            $sprintDefinition = new Definition(SprintDefinition::class);
            $sprintDefinition->setArguments([$sprint['label'], $sprint['url'], $dateStartDefinition, $dateIntervalDefinition, $sprint['repeat']]);
            $sprintManagerDefinition->addMethodCall('set', [$name, $sprintDefinition]);
        }
    }
}
