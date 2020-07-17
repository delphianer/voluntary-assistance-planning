<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Operationshifts;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search operationshifts");
    }

    /**
     * Searches for operationshifts
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Operationshifts::class, $this->request->getQuery());
        $builder->orderBy("start");

        $count = Operationshifts::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts');
            $this->dispatcher->forward([
                "controller" => "operationshifts",
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
        $this->view->setVar('extraTitle', "Found operationshifts");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Operationshifts");
    }

    /**
     * Edits a operationshift
     *
     * @param string $id
     */
    public function editAction($id)
    {
        // todo: setup id by params of dispatcher because this is a post when comming from OperationsController
        // see VehiclePropertiesController -> editAction

        if (!$this->request->isPost()) {
            $operationshift = Operationshifts::findFirstByid($id);
            if (!$operationshift) {
                $this->flash->error("operationshift was not found");

                $this->dispatcher->forward([
                    'controller' => "operationshifts",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operationshift->getId();

            $this->tag->setDefault("id", $operationshift->getId());
            $this->tag->setDefault("operationId", $operationshift->getOperationid());
            $this->tag->setDefault("locationId", $operationshift->getLocationid());
            $this->tag->setDefault("create_time", $operationshift->getCreateTime());
            $this->tag->setDefault("create_userId", $operationshift->getCreateUserid());
            $this->tag->setDefault("update_time", $operationshift->getUpdateTime());
            $this->tag->setDefault("update_userId", $operationshift->getUpdateUserid());
            $this->tag->setDefault("shortDescription", $operationshift->getShortdescription());
            $this->tag->setDefault("longDescription", $operationshift->getLongdescription());
            $this->tag->setDefault("start", $operationshift->getStart());
            $this->tag->setDefault("end", $operationshift->getEnd());

            // todo: handleProcessOperation -> comming from OperationsController
            // see VehiclePropertiesController -> editAction
            // todo: setup form
        }

        $this->view->setVar('extraTitle', "Edit Operationshifts");
    }

    /**
     * Creates a new operationshift
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operationshifts",'action' => 'index']);
            return;
        }

        $operationshift = new Operationshifts();
        $operationshift->setupdateUserId($this->auth->getUser()->id);
        $operationshift->setcreateUserId($this->auth->getUser()->id);
        $this->setOperationShiftDetails($operationshift);


        if (!$operationshift->save()) {
            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operationshift was created successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operationshift edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operationshift = Operationshifts::findFirstByid($id);

        if (!$operationshift) {
            $this->flash->error("operationshift does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        $operationshift->setupdateTime(getCurrentDateTimeStamp());
        $operationshift->setupdateUserId($this->auth->getUser()->id);
        $this->setOperationShiftDetails($operationshift);


        if (!$operationshift->save()) {

            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'edit',
                'params' => [$operationshift->getId()]
            ]);

            return;
        }

        $this->flash->success("operationshift was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operationshift
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operationshift = Operationshifts::findFirstByid($id);
        if (!$operationshift) {
            $this->flash->error("operationshift was not found");

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operationshift->delete()) {

            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operationshift was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => "index"
        ]);
    }

    /**
     * @param Operationshifts $operationshift
     */
    public function setOperationShiftDetails(Operationshifts $operationshift): void
    {
        $operationshift->setoperationId($this->request->getPost("operationId", "int"));
        $operationshift->setlocationId($this->request->getPost("locationId", "int"));
        $operationshift->setshortDescription($this->request->getPost("shortDescription", "string"));
        $operationshift->setlongDescription($this->request->getPost("longDescription", "string"));
        $operationshift->setstart($this->request->getPost("start", "int"));
        $operationshift->setend($this->request->getPost("end", "int"));
    }
}
