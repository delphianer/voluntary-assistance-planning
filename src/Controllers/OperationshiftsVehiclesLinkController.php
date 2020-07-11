<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\OperationshiftsVehiclesLink;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsVehiclesLinkController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        // todo: check if private fits and remove this todo
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Search operationshifts_vehicles_link");
    }

    /**
     * Searches for operationshifts_vehicles_link
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), OperationshiftsVehiclesLink::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = OperationshiftsVehiclesLink::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts_vehicles_link');
            $this->dispatcher->forward([
                "controller" => "operationshifts_vehicles_link",
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
        $this->view->setVar('extraTitle', "Found operationshifts_vehicles_link");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New OperationshiftsVehiclesLink");
    }

    /**
     * Edits a operationshifts_vehicles_link
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $operationshifts_vehicles_link = OperationshiftsVehiclesLink::findFirstByid($id);
            if (!$operationshifts_vehicles_link) {
                $this->flash->error("operationshifts_vehicles_link was not found");

                $this->dispatcher->forward([
                    'controller' => "operationshifts_vehicles_link",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operationshifts_vehicles_link->getId();

            $this->tag->setDefault("id", $operationshifts_vehicles_link->getId());
            $this->tag->setDefault("operationShiftId", $operationshifts_vehicles_link->getOperationshiftid());
            $this->tag->setDefault("vehicleId", $operationshifts_vehicles_link->getVehicleid());
            $this->tag->setDefault("create_time", $operationshifts_vehicles_link->getCreateTime());
            $this->tag->setDefault("update_time", $operationshifts_vehicles_link->getUpdateTime());
            $this->tag->setDefault("shortDescription", $operationshifts_vehicles_link->getShortdescription());
            $this->tag->setDefault("longDescription", $operationshifts_vehicles_link->getLongdescription());
            
        }

        $this->view->setVar('extraTitle', "Edit OperationshiftsVehiclesLink");
    }

    /**
     * Creates a new operationshifts_vehicles_link
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operationshifts_vehicles_link",'action' => 'index']);
            return;
        }

        $operationshifts_vehicles_link = new OperationshiftsVehiclesLink();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshifts_vehicles_link->setoperationShiftId($this->request->getPost("operationShiftId", "int"));
        $operationshifts_vehicles_link->setvehicleId($this->request->getPost("vehicleId", "int"));
        $operationshifts_vehicles_link->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshifts_vehicles_link->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshifts_vehicles_link->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshifts_vehicles_link->setlongDescription($this->request->getPost("longDescription", "int"));
        

        if (!$operationshifts_vehicles_link->save()) {
            foreach ($operationshifts_vehicles_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operationshifts_vehicles_link was created successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_vehicles_link",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operationshifts_vehicles_link edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operationshifts_vehicles_link = OperationshiftsVehiclesLink::findFirstByid($id);

        if (!$operationshifts_vehicles_link) {
            $this->flash->error("operationshifts_vehicles_link does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $operationshifts_vehicles_link->setupdateTime(getCurrentDateTimeStamp());
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshifts_vehicles_link->setoperationShiftId($this->request->getPost("operationShiftId", "int"));
        $operationshifts_vehicles_link->setvehicleId($this->request->getPost("vehicleId", "int"));
        $operationshifts_vehicles_link->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshifts_vehicles_link->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshifts_vehicles_link->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshifts_vehicles_link->setlongDescription($this->request->getPost("longDescription", "int"));
        

        if (!$operationshifts_vehicles_link->save()) {

            foreach ($operationshifts_vehicles_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'edit',
                'params' => [$operationshifts_vehicles_link->getId()]
            ]);

            return;
        }

        $this->flash->success("operationshifts_vehicles_link was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_vehicles_link",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operationshifts_vehicles_link
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operationshifts_vehicles_link = OperationshiftsVehiclesLink::findFirstByid($id);
        if (!$operationshifts_vehicles_link) {
            $this->flash->error("operationshifts_vehicles_link was not found");

            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operationshifts_vehicles_link->delete()) {

            foreach ($operationshifts_vehicles_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_vehicles_link",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operationshifts_vehicles_link was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_vehicles_link",
            'action' => "index"
        ]);
    }
}
