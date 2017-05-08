<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum;

use DateInterval;
use DateTime;
use Endroid\Calendar\Reader\IcalReader;

class Sprint
{

    /**
     * @var DateTime
     */
    protected $dateStart;

    /**
     * @var DateTime
     */
    protected $dateEnd;

    /**
     * @var SprintDefinition
     */
    protected $definition;

    /**
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     * @param SprintDefinition $definition
     */
    public function __construct(DateTime $dateStart, DateTime $dateEnd, SprintDefinition $definition)
    {
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->definition = $definition;
    }

    /**
     * @return DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @return DateTime
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @return SprintDefinition
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @return int
     */
    public function getDayCount()
    {
        return $this->definition->getDateInterval()->format('%d');
    }

    /**
     * @return UserStory[]
     */
    public function getUserStories()
    {
        $reader = new IcalReader();
        $calendar = $reader->readFromUrl($this->definition->getUrl());
        $events = $calendar->getEvents($this->dateStart, $this->dateEnd);

        $userStories = [];
        foreach ($events as $event) {
            preg_match('#(.*) [a-z]*([0-9]+)#i', $event->getTitle(), $matches);
            $userStory = new UserStory($matches[1], $event->getDateStart(), intval($matches[2]), $this);
            $userStories[] = $userStory;
        }

        return $userStories;
    }

    /**
     * @return array
     */
    public function getUserStoriesByDay()
    {
        $dayInterval = new DateInterval('P1D');

        $userStories = [];
        $currentDate = clone $this->dateStart;
        while ($currentDate < $this->dateEnd) {
            $userStories[$currentDate->format('Y-m-d')] = [];
            $currentDate->add($dayInterval);
        }

        foreach ($this->getUserStories() as $userStory) {
            $userStories[$userStory->getDate()->format('Y-m-d')][$userStory->getLabel()] = $userStory->getStoryPoints();
        }

        return $userStories;
    }
}
