<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CalendarScrum\Bundle\Controller;

use Endroid\CalendarScrum\SprintDefinitionRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CalendarScrumController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $sprintDefinitions = $this->getSprintDefinitionRegistry()->getAll();

        return [
            'sprintDefinitions' => $sprintDefinitions
        ];
    }

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
        return $this->get('endroid_calendar_scrum.sprint_definition_registry');
    }
}
