<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\ScrumCalendar;

use DateInterval;
use DateTime;

class SprintDefinition
{
    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var DateTime
     */
    protected $dateStart;

    /**
     * @var DateInterval
     */
    protected $dateInterval;

    /**
     * @var bool
     */
    protected $repeat;

    /**
     * @param string $label
     * @param string $url
     * @param DateTime $dateStart
     * @param DateInterval $dateInterval
     * @param bool $repeat
     */
    public function __construct($label, $url, DateTime $dateStart, DateInterval $dateInterval, $repeat)
    {
        $this->label = $label;
        $this->url = $url;
        $this->dateStart = $dateStart;
        $this->dateInterval = $dateInterval;
        $this->repeat = $repeat;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return DateTime
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @return DateInterval
     */
    public function getDateInterval()
    {
        return $this->dateInterval;
    }

    /**
     * @return bool
     */
    public function isRepeat()
    {
        return $this->repeat;
    }

    /**
     * @param int $index
     * @return Sprint
     */
    public function getSprint($index = 0)
    {
        $dateStart = clone $this->dateStart;

        $currentDate = new DateTime();
        while ($dateStart < $currentDate) {
            $dateStart->add($this->dateInterval);
        }

        $dateStart->sub($this->dateInterval);

        $dateEnd = clone $dateStart;
        $dateEnd->add($this->dateInterval);

        $sprint = new Sprint($dateStart, $dateEnd, $this);

        return $sprint;
    }
}
