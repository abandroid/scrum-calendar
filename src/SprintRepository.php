<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum;

class SprintRepository
{
    /**
     * @var Sprint[]
     */
    protected $sprints;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sprints = [];
    }

    /**
     * @param Sprint $sprint
     * @return $this
     */
    public function add(Sprint $sprint)
    {
        $this->sprints[$sprint->getName()] = $sprint;

        return $this;
    }

    /**
     * @param string $name
     * @return Sprint
     */
    public function find($name)
    {
        return $this->sprints[$name];
    }

    /**
     * @return Sprint[]
     */
    public function findAll()
    {
        return $this->sprints;
    }
}
