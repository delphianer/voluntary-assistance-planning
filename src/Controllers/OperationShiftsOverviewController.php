<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Vokuro\Models\Operations;
use Vokuro\Models\Volunteers;
use Vokuro\Plugins\Auth\Exception;

class OperationShiftsOverviewController extends ControllerBase
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
        try {
            $this->view->setVar('extraTitle', "Operation Shift Overview");

            $origin = $this->request->get('origin');
            $opid = intval($this->request->get('opid'));
            if ($opid==0) {
                $origin = $this->dispatcher->getParam('origin');
                $opid = intval($this->dispatcher->getParam('opid'));
            }

            $this->view->setVar('origin', $origin);

            $operation = Operations::findFirstByid($opid);
            $this->view->setVar('operation', $operation);

            $identity = $this->auth->getIdentity();
            $volunteer = Volunteers::findFirst(['[userId] = ' .$identity['id']]);

            $eventList = new EventlistController();
            $this->view->setVar('operationShiftsWithCommitmentList', $eventList->getOperationShiftsWithCommitmentFormat($opid, $volunteer));
        } catch (Exception $ex) {
            return $this->response->redirect('landingpage');
        }
    }
}
