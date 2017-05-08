<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum;

use DateTime;

class UserStory
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $storyPoints;

    /**
     * @var Sprint
     */
    protected $sprint;

    /**
     * @param string $label
     * @param DateTime $date
     * @param int $storyPoints
     * @param Sprint $sprint
     */
    public function __construct($label, DateTime $date, $storyPoints, Sprint $sprint)
    {
        $this->label = $label;
        $this->date = $date;
        $this->storyPoints = $storyPoints;
        $this->sprint = $sprint;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getStoryPoints()
    {
        return $this->storyPoints;
    }

    /**
     * @return Sprint
     */
    public function getSprint()
    {
        return $this->sprint;
    }
}
