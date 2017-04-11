<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EndroidCalendarScrumBundle\Controller;

use DateInterval;
use DateTime;
use Endroid\Calendar\Entity\Calendar;
use Endroid\Calendar\Reader\IcalReader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/scrum")
 */
class ScrumController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $url = 'https://calendar.google.com/calendar/ical/b7paql3k47d28akdmmeml8dk6o%40group.calendar.google.com/private-5a45e8ab9886e577c524a76c139158e4/basic.ics';

        $reader = new IcalReader();
        $calendar = $reader->readFromUrl($url);

        $dateStart = new DateTime(date('Y-m').'-01 00:00:00');
        $dateEnd = clone $dateStart;
//        $dateStart->sub(new DateInterval('P6M'));
        $dateEnd->add(new DateInterval('P1M'));

        $sprints = [];
        $interval = new DateInterval('P1M');
        $currentStart = clone $dateStart;
        while ($currentStart < $dateEnd) {
            $currentEnd = clone $currentStart;
            $currentEnd->add($interval);
            $sprints[] = $this->getSprintData($calendar, $currentStart, $currentEnd);
            $currentStart->add($interval);
        }

        return [
            'sprints' => $sprints,
        ];
    }

    /**
     * @param Calendar $calendar
     * @param DateTime $dateStart
     * @param DateTime $dateEnd
     * @return array
     */
    protected function getSprintData(Calendar $calendar, DateTime $dateStart, DateTime $dateEnd)
    {
        $sprintData = [
            'label' => $dateStart->format('Y-m'),
            'days' => [],
            'cumulative' => 0,
        ];

        $currentDate = clone $dateStart;
        $interval = new DateInterval('P1D');
        while ($currentDate < $dateEnd) {
            $sprintData['days'][$currentDate->format('Y-m-d')] = [
                'tasks' => [],
                'total' => 0,
                'date' => clone $currentDate,
            ];
            $currentDate->add($interval);
        }

        foreach ($calendar->getEvents($dateStart, $dateEnd) as $event) {
            $date = $event->getDateStart()->format('Y-m-d');
            preg_match('#(.*) (.)([0-9]+)#i', $event->getTitle(), $matches);

            $sprintData['days'][$date]['tasks'][] = $matches[1];
            $sprintData['days'][$date]['total'] += $matches[3];
            $sprintData['cumulative'] += $matches[3];
        }

        return $sprintData;
    }
}
