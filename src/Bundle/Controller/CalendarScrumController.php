<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum\Bundle\Controller;

use DateInterval;
use DateTime;
use Endroid\Calendar\Entity\Calendar;
use Endroid\CalendarScrum\SprintRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarScrumController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $sprints = $this->getSprintRepository()->findAll();

        return [
            'sprints' => $sprints,
        ];
    }

    /**
     * @Route("/{name}")
     * @Template()
     */
    public function sprintAction($name)
    {
        $sprint = $this->getSprintRepository()->find($name);

        return [
            'sprint' => $sprint
        ];
    }

    /**
     * @return SprintRepository
     */
    protected function getSprintRepository()
    {
        return $this->get('endroid_calendar_scrum.sprint_repository');
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
                'total' => 0,
                'date' => clone $currentDate,
                'tooltip' => '',
                'label' => '',
            ];
            $currentDate->add($interval);
        }

        foreach ($calendar->getEvents($dateStart, $dateEnd) as $event) {
            $date = $event->getDateStart()->format('Y-m-d');
            preg_match('#(.*) (.)([0-9]+)#i', $event->getTitle(), $matches);

            $sprintData['days'][$date]['label'] = $date == date('Y-m-d') ? 'Today' : '';
            $sprintData['days'][$date]['tooltip'] .= $matches[1].' ('.$matches[3].')<br />';
            $sprintData['days'][$date]['total'] += $matches[3];
            $sprintData['cumulative'] += $matches[3];
        }

        return $sprintData;
    }
}
