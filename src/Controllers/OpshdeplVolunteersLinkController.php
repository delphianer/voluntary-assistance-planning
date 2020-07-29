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

        $origin = $this->request->get('origin');
        $this->view->setVar('origin', $origin);

        $opshid = $this->request->get('opshid');
        $dnid = $this->request->get('dnid');

        $formOptions = [];

        $operationShift = Operationshifts::findFirstByid($opshid);
        $this->view->setVar('operationShift', $operationShift);
        $formOptions['operationShift'] = $operationShift;

        $operationShiftDepartmentNeeds = OperationshiftsDepartmentsLink::findFirstByid($dnid);
        $this->view->setVar('operationShiftDepartmentNeeds', $operationShiftDepartmentNeeds);
        $formOptions['operationShiftDepartmentNeeds'] = $operationShiftDepartmentNeeds;

        $identity = $this->auth->getIdentity();
        $volunteer = Volunteers::findFirst(['userId' >= $identity['id']]);
        $this->view->setVar('volunteer', $volunteer);
        $formOptions['volunteer'] = $volunteer;

        $form = new VolunteersCommitmentForm(null, $formOptions);
        $this->view->setVar('form', $form);

        /*
        todo: backAction definieren
{% if backAction is defined %}
     {{ hidden_field('backActionController', 'value':backActionController) }}
     {{ hidden_field('backActionValue', 'value':backActionValue) }}
{% endif %}
        */



    }

    /**
     * Edits a opshdepl_volunteers_link
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirstByid($id);
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

        $this->flash->success("opshdepl_volunteers_link was created successfully");

        $this->dispatcher->forward([
            'controller' => "opshdepl_volunteers_link",
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

        $this->flash->success("opshdepl_volunteers_link was updated successfully");

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
    public function deleteAction($id)
    {
        $opshdepl_volunteers_link = OpshdeplVolunteersLink::findFirstByid($id);
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

        $this->flash->success("opshdepl_volunteers_link was deleted successfully");

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
}
