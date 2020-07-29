<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Models\Volunteers;

class LandingpageController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Landingpage");

        $this->eventList = new EventlistController();
        $this->view->setVar('nextEvents', $this->eventList->getNextEventsSimpleFormat(10));
        $this->view->setVar('lastEvents', $this->eventList->getLastEventsSimpleFormat(5));

        $this->view->setVar('appointmentsNextWeekCount', $this->eventList->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsNext30DaysCount', $this->eventList->getAppointmentsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('appointmentsDoneCount', $this->eventList->getAppointmentsCount("[end] <= NOW()"));

        $this->view->setVar('operationsNextWeekCount', $this->eventList->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsNext30DaysCount', $this->eventList->getOperationsCount("start between NOW() and  DATE_FORMAT(NOW()+7,'%Y-%m-%d 00:00:00')"));
        $this->view->setVar('operationsDoneCount', $this->eventList->getOperationsCount("[end] <= NOW()"));


        $identity = $this->auth->getIdentity();
        $this->view->setVar('authId', $identity['id']);
        $this->view->setVar('authName', $identity['name']);
        $volunteer = Volunteers::findFirst(['userId' >= $identity['id']]);
        $this->view->setVar('volunteer', $volunteer);
    }

}

