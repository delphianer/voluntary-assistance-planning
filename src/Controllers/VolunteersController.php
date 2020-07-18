<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\DateTimePicker;
use Vokuro\Forms\VolunteersForm;
use Vokuro\Models\Certificates;
use Vokuro\Models\Volunteers;
use Vokuro\Models\VolunteersCertificatesLink;
use function Vokuro\getCurrentDateTimeStamp;

class VolunteersController extends ControllerBase
{
    use DateTimePicker;

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
        $form = new VolunteersForm();
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "Search volunteers");
    }

    /**
     * Searches for volunteers
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Volunteers::class, $this->request->getQuery());
        $builder->orderBy("firstName, lastName");

        $count = Volunteers::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any volunteers');
            $this->dispatcher->forward([
                "controller" => "volunteers",
                'action' => 'index',
            ]);

            return;
        }

        $paginator   = new Paginator(
            [
                'builder'   => $builder->createBuilder(),
                'limit'     => 10,
                'page'      => $this->request->getQuery('page', 'int', 1),
            ]
        );

        $page = $paginator->paginate();
        $this->view->setVar('page', $page);
        $this->view->setVar('extraTitle', "Found volunteers");
    }

    /**
     * Displays the creation form
     */
    public function newAction() // preparation of "create"-Process
    {
        $form = new VolunteersForm();
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "New Volunteers");
    }

    /**
     * Edits a volunteer
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $volunteerId = $this->dispatcher->getParam('volunteerId');
        if (isset($volunteerId)) {
            $id = $volunteerId;
        }

        if (!$this->request->isPost() || isset($volunteerId)) {
            $volunteer = Volunteers::findFirstByid($id);
            if (!$volunteer) {
                $this->flash->error("volunteer was not found");

                $this->dispatcher->forward([
                    'controller' => "volunteers",
                    'action' => 'index'
                ]);

                return;
            }
            $form = new VolunteersForm();
            $this->view->setVar('form', $form);

            $this->view->id = $volunteer->getId();

            $this->tag->setDefault("id", $volunteer->getId());
            $this->tag->setDefault("firstName", $volunteer->getFirstname());
            $this->tag->setDefault("lastName", $volunteer->getLastname());
            $this->tag->setDefault("userId", $volunteer->getUserid());
            $this->tag->setDefault("departmentId", $volunteer->getDepartmentid());

            // todo: go on with this: volCertLnkId
            $volCertLnkId = $this->dispatcher->getParam('volCertLnkId');
            if (isset($volCertLnkId) && ($volCertLnkId > 0)) {
                $certLink = VolunteersCertificatesLink::findFirstByid($volCertLnkId);
                $this->tag->setDefault("volCertLnkId", $certLink->getId());
                $this->tag->setDefault("certificate", $certLink->getCertificatesId());
                $this->tag->setDefault("certValidUntil", $certLink->getValidUntil());
            }
        }
        $this->setupDateTimePicker();

        $this->view->setVar('volunteer', $volunteer);
        $this->view->setVar('extraTitle', "Edit Volunteers");
    }

    /**
     * Creates a new volunteer
     */
    public function createAction() // the other part is "newAction"
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "volunteers",'action' => 'index']);
            return;
        }

        $volunteer = new Volunteers();
        $this->setVolunteerDetails($volunteer);


        if (!$volunteer->save()) {
            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("volunteer was created successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a volunteer edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $volunteer = Volunteers::findFirstByid($id);

        if (!$volunteer) {
            $this->flash->error("volunteer does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        $volunteer->setupdateTime(getCurrentDateTimeStamp());
        $this->setVolunteerDetails($volunteer);

        if (!$volunteer->save()) {
            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'edit',
                'params' => [$volunteer->getId()]
            ]);

            return;
        }

        if ($this->handeledSubmitCertificate(($this->request->getPost("submitAction", "string")), $volunteer)) {
            return;
        }

        $this->flash->success("volunteer was updated successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a volunteer
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $volunteer = Volunteers::findFirstByid($id);
        if (!$volunteer) {
            $this->flash->error("volunteer was not found");

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        if (!$volunteer->delete()) {
            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("volunteer was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => "index"
        ]);
    }

    /**
     * @param Volunteers $volunteer
     */
    public function setVolunteerDetails(Volunteers $volunteer): void
    {
        $volunteer->setfirstName($this->request->getPost("firstName", "string"));
        $volunteer->setlastName($this->request->getPost("lastName", "string"));
        $var = $this->request->getPost("userId", "int");
        if ($var > 0) {
            $volunteer->setuserId($var); // else null!
        }
        $volunteer->setdepartmentId($this->request->getPost("departmentId", "int"));
    }

    /**
     * @param $submitAction
     * @param Volunteers $volunteer
     * @return bool
     */
    private function handeledSubmitCertificate($submitAction, $volunteer)
    {
        if ($submitAction == 'submit') { // nothing to change
            return false;
        }

        if ($submitAction == 'saveCertDefinition') {
            $volCertLnkId = $this->request->getPost("volCertLnkId", "int");
            if (isset($volCertLnkId) && ($volCertLnkId > 0)) {
                $cert = VolunteersCertificatesLink::findFirstByid($volCertLnkId);
            } else {
                $cert = new VolunteersCertificatesLink();
                $cert->setCreateTime(getCurrentDateTimeStamp());
            }
            $cert->setUpdateTime(getCurrentDateTimeStamp());
            $cert->setVolunteersId($volunteer->getId());
            $cert->setCertificatesId($this->request->getPost("certificate", "int"));
            $cert->setValidUntil($this->request->getPost("certValidUntil", "DateTime"));
            if (!$cert->save()) {
                foreach ($cert->getMessages() as $message) {
                    $this->flash->error($message->getMessage());
                }
            }
            $this->dispatcher->setParam('volunteerId', $volunteer->getId());
            $this->view->setVar('setActiveTabKey', 'certificates');
            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'edit'
            ]);
            return true;
        }

        // edit existing certificate
        if (preg_match('/^edit\d/', $submitAction)) {
            $volCertLnkId = preg_replace('/^edit/', '', $submitAction);
            $this->dispatcher->setParam('volunteerId', $volunteer->getId());
            $this->dispatcher->setParam('volCertLnkId', $volCertLnkId);
            $this->view->setVar('setActiveTabKey', 'certificates');
            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'edit'
            ]);

            return true;
        }

        // delete existing certificate
        if (preg_match('/^del\d/', $submitAction)) {
            $volCertLnkId = preg_replace('/^del/', '', $submitAction);

            if (isset($volCertLnkId) && ($volCertLnkId > 0)) {
                $cert = VolunteersCertificatesLink::findFirstByid($volCertLnkId);
                if (!$cert->delete()) {
                    foreach ($cert->getMessages() as $message) {
                        $this->flash->error($message->getMessage());
                    }
                }
            }
            $this->view->setVar('setActiveTabKey', 'certificates');
            $this->dispatcher->setParam('volunteerId', $volunteer->getId());
            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'edit'
            ]);

            return true;
        }
        return false;
    }
}
