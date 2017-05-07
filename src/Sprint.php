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

class Sprint
{
    /**
     * @var string
     */
    protected $name;

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
     * @param string $name
     * @param string $url
     * @param string $start
     * @param string $interval
     * @param bool $repeat
     */
    public function __construct($name, $url, $start, $interval, $repeat)
    {
        $this->name = $name;
        $this->url = $url;
        $this->dateStart = new DateTime($start.' 00:00:00');
        $this->dateInterval = new DateInterval($interval);
        $this->repeat = $repeat;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
}
