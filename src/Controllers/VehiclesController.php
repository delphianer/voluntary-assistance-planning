<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Vehicles;
use function Vokuro\getCurrentDateTimeStamp;
use function Vokuro\translateFromYesNo;

class VehiclesController extends ControllerBase
{
    /**
     * init method
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
        $this->view->setVar('extraTitle', "Search vehicles");
    }

    /**
     * Searches for vehicles
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, Vehicles::class, $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Vehicles',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any vehicles");

            $this->dispatcher->forward([
                "controller" => "vehicles",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found vehicles");
        $this->view->page = $paginate;
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
        if (!$this->request->isPost()) { // should go to "new"
            $this->dispatcher->forward([ 'controller' => "vehicles",'action' => 'index']);
            return;
        }

        $vehicle = new Vehicles();
        $this->setVehicleDetails($vehicle);


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

        $vehicle->setupdateTime(getCurrentDateTimeStamp());
        $this->setVehicleDetails($vehicle);


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

    /**
     * @param $vehicle
     */
    public function setVehicleDetails($vehicle): void
    {
        $vehicle->setLabel($this->request->getPost("label", "string"));
        $vehicle->setDescription($this->request->getPost("description", "string"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "DateTime"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance(translateFromYesNo($this->request->getPost("isAmbulance", "string")));
        $vehicle->sethasFlashingLights(translateFromYesNo($this->request->getPost("hasFlashingLights", "string")));
        $vehicle->sethasRadioCom(translateFromYesNo($this->request->getPost("hasRadioCom", "string")));
        $vehicle->sethasDigitalRadioCom(translateFromYesNo($this->request->getPost("hasDigitalRadioCom", "string")));
    }
}
