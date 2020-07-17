<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Forms\OperationsForm;
use Vokuro\Models\Operations;
use function Vokuro\getCurrentDateTimeStamp;

class OperationsController extends ControllerBase
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
        $form = new OperationsForm();
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "Search operations");
    }

    /**
     * Searches for operations
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Operations::class, $this->request->getQuery());
        $builder->orderBy("shortDescription");

        $count = Operations::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operations');
            $this->dispatcher->forward([
                "controller" => "operations",
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

        $this->view->setVar('page', $paginator->paginate());
        $this->view->setVar('extraTitle', "Found operations");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $form = new OperationsForm();
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "New Operations");
    }

    /**
     * Edits a operation
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $processOperationsId = $this->dispatcher->getParam('processOperationsId');
        if (isset($processOperationsId)) {
            $id = $processOperationsId;
        }

        if (!$this->request->isPost() || isset($processOperationsId)) {
            $operation = Operations::findFirstByid($id);
            if (!$operation) {
                $this->flash->error("operation was not found");

                $this->dispatcher->forward([
                    'controller' => "operations",
                    'action' => 'index'
                ]);

                return;
            }
            $form = new OperationsForm();
            $this->view->setVar('form', $form);
            $this->view->setVar('operation', $operation);

            $this->view->id = $operation->getId();

            $this->tag->setDefault("id", $operation->getId());
            $this->tag->setDefault("clientId", $operation->getClientid());
            $this->tag->setDefault("create_time", $operation->getCreateTime());
            $this->tag->setDefault("create_userId", $operation->getCreateUserid());
            $this->tag->setDefault("update_time", $operation->getUpdateTime());
            $this->tag->setDefault("update_userId", $operation->getUpdateUserid());
            $this->tag->setDefault("shortDescription", $operation->getShortdescription());
            $this->tag->setDefault("longDescription", $operation->getLongdescription());
            $this->tag->setDefault("mainDepartmentId", $operation->getMaindepartmentid());
        }

        $this->view->setVar('extraTitle', "Edit Operations");
    }

    /**
     * Creates a new operation
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operations",'action' => 'index']);
            return;
        }

        $operation = new Operations();
        $operation->setcreateUserId($this->auth->getUser()->id);
        $this->setOperationDetails($operation);


        if (!$operation->save()) {
            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operation was created successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operation edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operation = Operations::findFirstByid($id);

        if (!$operation) {
            $this->flash->error("operation does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        $operation->setupdateTime(getCurrentDateTimeStamp());
        $this->setOperationDetails($operation);


        if (!$operation->save()) {
            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'edit',
                'params' => [$operation->getId()]
            ]);

            return;
        }

        if ($this->handledSubmitAction($this->request->getPost("submitAction"), $operation)){
            return;
        }

        $this->flash->success("operation was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operation
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operation = Operations::findFirstByid($id);
        if (!$operation) {
            $this->flash->error("operation was not found");

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operation->delete()) {
            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operation was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => "index"
        ]);
    }

    /**
     * @param Operations $operation
     */
    public function setOperationDetails(Operations $operation): void
    {
        $operation->setclientId($this->request->getPost("clientId", "int"));
        $operation->setupdateUserId($this->auth->getUser()->id);
        $operation->setshortDescription($this->request->getPost("shortDescription", "string"));
        $operation->setlongDescription($this->request->getPost("longDescription", "string"));
        $operation->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
    }

    private function handledSubmitAction($submitAction, $operation)
    {
        if ($submitAction == 'submit') { // nothing to change -> correct submit button
            return false;
        }

        // create new property
        if ($submitAction == 'goToShift') {
            $this->dispatcher->setParam('processOperationId', $operation->getId());
            $this->dispatcher->setParam('OperationShortDesc', $operation->getShortDescription());
            $this->dispatcher->forward([
                'controller' => "OperationShifts",
                'action' => 'new'
            ]);

            return true;
        }

        // edit existing property
        if (preg_match('/^edit\d/', $submitAction)) {
            $shiftId = preg_replace('/^edit/', '', $submitAction);
            $this->dispatcher->setParam('processOperationId', $operation->getId());
            $this->dispatcher->setParam('OperationShortDesc', $operation->getShortDescription());
            $this->dispatcher->setParam('OperationShiftsId', $shiftId);
            $this->dispatcher->forward([
                'controller' => "OperationShifts",
                'action' => 'edit'
            ]);

            return true;
        }

        // delete existing property
        if (preg_match('/^del\d/', $submitAction)) {
            $shiftId = preg_replace('/^del/', '', $submitAction);
            $this->dispatcher->setParam('processOperationId', $operation->getId());
            $this->dispatcher->setParam('OperationShiftsId', $shiftId);
            $this->dispatcher->forward([
                'controller' => "OperationShifts",
                'action' => 'delete'
            ]);

            return true;
        }
        return false;
    }
}
