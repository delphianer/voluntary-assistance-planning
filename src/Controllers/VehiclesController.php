<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Vehicles;
use function Vokuro\getCurrentDateTimeStamp;

class VehiclesController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search vehicles");
    }

    /**
     * Searches for vehicles
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Vehicles::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = Vehicles::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any vehicles');
            $this->dispatcher->forward([
                "controller" => "vehicles",
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
        $this->view->setVar('extraTitle', "Found vehicles");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Vehicles");
    }

    /**
     * Edits a vehicle
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $vehicle = Vehicles::findFirstByid($id);
            if (!$vehicle) {
                $this->flash->error("vehicle was not found");

                $this->dispatcher->forward([
                    'controller' => "vehicles",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $vehicle->getId();

            $this->tag->setDefault("id", $vehicle->getId());
            $this->tag->setDefault("create_time", $vehicle->getCreateTime());
            $this->tag->setDefault("update_time", $vehicle->getUpdateTime());
            $this->tag->setDefault("label", $vehicle->getLabel());
            $this->tag->setDefault("description", $vehicle->getDescription());
            $this->tag->setDefault("technicalInspection", $vehicle->getTechnicalinspection());
            $this->tag->setDefault("seatCount", $vehicle->getSeatcount());
            $this->tag->setDefault("isAmbulance", $vehicle->getIsambulance());
            $this->tag->setDefault("hasFlashingLights", $vehicle->getHasflashinglights());
            $this->tag->setDefault("hasRadioCom", $vehicle->getHasradiocom());
            $this->tag->setDefault("hasDigitalRadioCom", $vehicle->getHasdigitalradiocom());
            
        }

        $this->view->setVar('extraTitle', "Edit Vehicles");
    }

    /**
     * Creates a new vehicle
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "vehicles",'action' => 'index']);
            return;
        }

        $vehicle = new Vehicles();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $vehicle->setcreateUserId($this->auth->getUser()->id);
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $vehicle->setcreateTime($this->request->getPost("create_time", "int"));
        $vehicle->setupdateTime($this->request->getPost("update_time", "int"));
        $vehicle->setlabel($this->request->getPost("label", "int"));
        $vehicle->setdescription($this->request->getPost("description", "int"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "int"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance($this->request->getPost("isAmbulance", "int"));
        $vehicle->sethasFlashingLights($this->request->getPost("hasFlashingLights", "int"));
        $vehicle->sethasRadioCom($this->request->getPost("hasRadioCom", "int"));
        $vehicle->sethasDigitalRadioCom($this->request->getPost("hasDigitalRadioCom", "int"));
        

        if (!$vehicle->save()) {
            foreach ($vehicle->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("vehicle was created successfully");

        $this->dispatcher->forward([
            'controller' => "vehicles",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a vehicle edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $vehicle = Vehicles::findFirstByid($id);

        if (!$vehicle) {
            $this->flash->error("vehicle does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $vehicle->setupdateTime(getCurrentDateTimeStamp());
        // $vehicle->setupdateUserId($this->auth->getUser()->id);
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $vehicle->setcreateTime($this->request->getPost("create_time", "int"));
        $vehicle->setupdateTime($this->request->getPost("update_time", "int"));
        $vehicle->setlabel($this->request->getPost("label", "int"));
        $vehicle->setdescription($this->request->getPost("description", "int"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "int"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance($this->request->getPost("isAmbulance", "int"));
        $vehicle->sethasFlashingLights($this->request->getPost("hasFlashingLights", "int"));
        $vehicle->sethasRadioCom($this->request->getPost("hasRadioCom", "int"));
        $vehicle->sethasDigitalRadioCom($this->request->getPost("hasDigitalRadioCom", "int"));
        

        if (!$vehicle->save()) {

            foreach ($vehicle->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'edit',
                'params' => [$vehicle->getId()]
            ]);

            return;
        }

        $this->flash->success("vehicle was updated successfully");

        $this->dispatcher->forward([
            'controller' => "vehicles",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a vehicle
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $vehicle = Vehicles::findFirstByid($id);
        if (!$vehicle) {
            $this->flash->error("vehicle was not found");

            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'index'
            ]);

            return;
        }

        if (!$vehicle->delete()) {

            foreach ($vehicle->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("vehicle was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "vehicles",
            'action' => "index"
        ]);
    }
}
