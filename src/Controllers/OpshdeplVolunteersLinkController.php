<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Forms\VolunteersCommitmentForm;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;
use Vokuro\Models\OperationshiftsDepartmentsLink;
use Vokuro\Models\OpshdeplVolunteersLink;
use Vokuro\Models\Volunteers;
use function Vokuro\getCurrentDateTimeStamp;

class OpshdeplVolunteersLinkController extends ControllerBase
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

    /**
     * Index action
     */
    public function indexAction()
    {
        return $this->response->redirect('landingpage');
    }

    /**
     * Searches for opshdepl_volunteers_link
     */
    public function searchAction()
    {
        return $this->response->redirect('landingpage');
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Volunteer Commitment");

        $this->initFormByRequest();
    }

    /**
     * Edits a opshdepl_volunteers_link
     *
     * @param string $id
     */
    public function editAction($id = null)
    {
        if (!$this->request->isPost()) {
            if ((intval($this->request->get('opshid')) > 0) && (intval($this->request->get('opshid')) > 0)) {
                $this->initFormByRequest();
                $params = [
                    'opDepNeedId' => intval($this->request->get('dnid')),
                    'volunteersId' => $this->view->getVar('volunteer')->getId()
                ];
                $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirst($params);
            } elseif (is_null($id)) {
                $this->response->redirect('landingpage');
                return;
            } else {
                $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirstByid($id);
            }
            if (!$opshdepl_volunteers_link) {
                $this->flash->error("opshdepl_volunteers_link was not found");

                $this->dispatcher->forward([
                    'controller' => "opshdepl_volunteers_link",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $opshdepl_volunteers_link->getId();

            $this->tag->setDefault("id", $opshdepl_volunteers_link->getId());
            $this->tag->setDefault("create_time", $opshdepl_volunteers_link->getCreateTime());
            $this->tag->setDefault("update_time", $opshdepl_volunteers_link->getUpdateTime());
            $this->tag->setDefault("shortDescription", $opshdepl_volunteers_link->getShortdescription());
            $this->tag->setDefault("longDescription", $opshdepl_volunteers_link->getLongdescription());
            $this->tag->setDefault("opDepNeedId", $opshdepl_volunteers_link->getOpdepneedid());
            $this->tag->setDefault("volunteersId", $opshdepl_volunteers_link->getVolunteersid());
            $this->tag->setDefault("volCurrentMaximumCertRank", $opshdepl_volunteers_link->getVolcurrentmaximumcertrank());
        }

        $this->view->setVar('extraTitle', "Edit OpshdeplVolunteersLink");
    }

    /**
     * Creates a new opshdepl_volunteers_link
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            // todo: landingpage everywhere when process is not OK
            $this->dispatcher->forward([ 'controller' => "landingpage",'action' => 'index']);
            return;
        }

        $opshdepl_volunteers_link = new OpshdeplVolunteersLink();
        $this->setDetails($opshdepl_volunteers_link);


        if (!$opshdepl_volunteers_link->save()) {
            foreach ($opshdepl_volunteers_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "opshdeplvolunteerslink",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("Commitment was created successfully");

        $origin = $this->request->getPost("backActionController", "string");
        $opid = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($origin, $opid)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "opshdeplvolunteerslink",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a opshdepl_volunteers_link edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "opshdepl_volunteers_link",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirstByid($id);

        if (!$opshdepl_volunteers_link) {
            $this->flash->error("opshdepl_volunteers_link does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "opshdepl_volunteers_link",
                'action' => 'index'
            ]);

            return;
        }

        $opshdepl_volunteers_link->setupdateTime(getCurrentDateTimeStamp());
        $this->setDetails($opshdepl_volunteers_link);


        if (!$opshdepl_volunteers_link->save()) {
            foreach ($opshdepl_volunteers_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "opshdepl_volunteers_link",
                'action' => 'edit',
                'params' => [$opshdepl_volunteers_link->getId()]
            ]);

            return;
        }
        $this->flash->success("Commitment was updated successfully");

        $origin = $this->request->getPost("backActionController", "string");
        $opid = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($origin, $opid)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "opshdepl_volunteers_link",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a opshdepl_volunteers_link
     *
     * @param string $id
     */
    public function deleteAction($id = null)
    {
        $origin = '';
        $opid = 0;
        if ((intval($this->request->get('opshid')) > 0) && (intval($this->request->get('opshid')) > 0)) {
            $this->initFormByRequest();
            $params = [
                'opDepNeedId' => intval($this->request->get('dnid')),
                'volunteersId' => $this->view->getVar('volunteer')->getId()
            ];
            $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirst($params);
            $origin = $this->request->get('origin');
            $opid = $opshdepl_volunteers_link->OperationshiftsDepartmentsLink->Operationshifts->getOperationId();
        } elseif (is_null($id)) {
            $this->response->redirect('landingpage');
            return;
        } else {
            $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirstByid($id);
        }
        if (!$opshdepl_volunteers_link) {
            $this->flash->error("opshdepl_volunteers_link was not found");

            $this->dispatcher->forward([
                'controller' => "opshdepl_volunteers_link",
                'action' => 'index'
            ]);

            return;
        }

        if (!$opshdepl_volunteers_link->delete()) {
            foreach ($opshdepl_volunteers_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "opshdepl_volunteers_link",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("Commitment was deleted successfully");

        if ($this->handledBackAction($origin,$opid)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "opshdepl_volunteers_link",
            'action' => "index"
        ]);
    }

    /**
     * @param OpshdeplVolunteersLink $opshdepl_volunteers_link
     */
    public function setDetails(OpshdeplVolunteersLink $opshdepl_volunteers_link): void
    {
        $opshdepl_volunteers_link->setshortDescription($this->request->getPost("shortDescription", "string"));
        $opshdepl_volunteers_link->setlongDescription($this->request->getPost("longDescription", "string"));
        $id = $this->request->getPost("opDepNeedId", "int");
        $opshdepl_volunteers_link->setopDepNeedId($id);
        $id = $this->request->getPost("volunteersId", "int");
        $opshdepl_volunteers_link->setvolunteersId($id);
        $opshdepl_volunteers_link->setvolCurrentMaximumCertRank($this->request->getPost("volCurrentMaximumCertRank", "int"));
    }


    private function initFormByRequest()
    {
        $origin = $this->request->get('origin');
        $opshid = intval($this->request->get('opshid'));
        $dnid = intval($this->request->get('dnid'));


        $formOptions = [];

        /**
         * @var Operationshifts $operationShift
         */
        $operationShift = Operationshifts::findFirstByid($opshid);
        $this->view->setVar('operationShift', $operationShift);
        $formOptions['operationShift'] = $operationShift;

        $this->view->setVar('backAction', $origin.'/?origin=landingpage&opid='.$operationShift->getOperationId());
        $this->view->setVar('backActionController', $origin);
        $this->view->setVar('backActionValue', $operationShift->getOperationId());

        $operationShiftDepartmentNeeds = OperationshiftsDepartmentsLink::findFirstByid($dnid);
        $this->view->setVar('operationShiftDepartmentNeeds', $operationShiftDepartmentNeeds);
        $formOptions['operationShiftDepartmentNeeds'] = $operationShiftDepartmentNeeds;

        $identity = $this->auth->getIdentity();
        $volunteer = Volunteers::findFirst(['userId' >= $identity['id']]);
        $this->view->setVar('volunteer', $volunteer);
        $formOptions['volunteer'] = $volunteer;

        $form = new VolunteersCommitmentForm(null, $formOptions);
        $this->view->setVar('form', $form);
    }

    /**
     * @param $backActionValue
     * @return bool
     */
    private function handledBackAction($origin, $opid)
    {
        if ((!empty($origin)) && ($opid > 0)) {
            //$this->response->redirect($origin.'/?origin=landingpage&opid='.$opid);
            $this->dispatcher->setParam('origin', 'landingpage');
            $this->dispatcher->setParam('opid', $opid);
            $this->dispatcher->forward([
                'controller' => $origin,
                'action' => "index"
            ]);
            return true;
        }
        return false;
    }
}
