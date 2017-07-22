<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\ScrumCalendar\Bundle\ScrumCalendarBundle\Controller;

use Endroid\ScrumCalendar\SprintDefinitionRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScrumCalendarController extends Controller
{
    /**
     * @Route("/{name}")
     * @Template()
     *
     * @param string $name
     * @return array
     */
    public function sprintDefinitionAction($name)
    {
        $sprintDefinition = $this->getSprintDefinitionRegistry()->get($name);

        return [
            'sprintDefinition' => $sprintDefinition
        ];
    }

    /**
     * @return SprintDefinitionRegistry
     */
    protected function getSprintDefinitionRegistry()
    {
        return $this->get('endroid_scrum_calendar.sprint_definition_registry');
    }
}
