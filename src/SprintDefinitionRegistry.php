<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum;

use Endroid\CalendarScrum\Exception\SprintDefinitionNotFoundException;

class SprintDefinitionRegistry
{
    /**
     * @var SprintDefinition[]
     */
    protected $sprintDefinitions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sprintDefinitions = [];
    }

    /**
     * @param string $name
     * @param SprintDefinition $sprint
     * @return $this
     */
    public function set($name, SprintDefinition $sprint)
    {
        $this->sprintDefinitions[$name] = $sprint;

        return $this;
    }

    /**
     * @param string $name
     * @return SprintDefinition
     * @throws SprintDefinitionNotFoundException
     */
    public function get($name)
    {
        if (!isset($this->sprintDefinitions[$name])) {
            throw new SprintDefinitionNotFoundException('Sprint definition "'.$name.'" not found');
        }

        return $this->sprintDefinitions[$name];
    }

    /**
     * @return SprintDefinition[]
     */
    public function getAll()
    {
        return $this->sprintDefinitions;
    }
}
