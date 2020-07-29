<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Models\Operations;
use Vokuro\Models\Volunteers;

class OperationShiftsOverviewController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    public function indexAction()
    {
        return $this->response->redirect('landingpage');
    }

    public function newAction()
    {
        $this->view->setVar('extraTitle', "Operation Shift Overview");

        $origin = $this->request->get('origin');
        $this->view->setVar('origin', $origin);

        $opid = $this->request->get('opid', null, null, true);

        $operation = Operations::findFirstByid($opid);
        $this->view->setVar('operation', $operation);

        $identity = $this->auth->getIdentity();
        $volunteer = Volunteers::findFirst(['userId' >= $identity['id']]);

        $eventList = new EventlistController();
        $this->view->setVar('operationShiftsWithCommitmentList', $eventList->getOperationShiftsWithCommitmentFormat($volunteer));



    }
}
