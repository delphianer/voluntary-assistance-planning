<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Models\Vehicles;

class VehiclesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for vehicles
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Vehicles', $_GET)->getParams();
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

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //
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
            $this->tag->setDefault("desc_short", $vehicle->getDescShort());
            $this->tag->setDefault("desc_long", $vehicle->getDescLong());
            $this->tag->setDefault("technicalInspection", $vehicle->getTechnicalinspection());
            $this->tag->setDefault("seatCount", $vehicle->getSeatcount());
            $this->tag->setDefault("isAmbulance", $vehicle->getIsambulance());
            $this->tag->setDefault("hasFlashingLights", $vehicle->getHasflashinglights());
            $this->tag->setDefault("hasRadioCom", $vehicle->getHasradiocom());
            $this->tag->setDefault("hasDigitalRadioCom", $vehicle->getHasdigitalradiocom());
            
        }
    }

    /**
     * Creates a new vehicle
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vehicles",
                'action' => 'index'
            ]);

            return;
        }

        $vehicle = new Vehicles();
        $vehicle->setcreateTime($this->request->getPost("create_time", "int"));
        $vehicle->setupdateTime($this->request->getPost("update_time", "int"));
        $vehicle->setdescShort($this->request->getPost("desc_short", "int"));
        $vehicle->setdescLong($this->request->getPost("desc_long", "int"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "int"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance($this->request->getPost("isAmbulance", "int"));
        $vehicle->sethasFlashingLights($this->request->getPost("hasFlashingLights", "int"));
        $vehicle->sethasRadioCom($this->request->getPost("hasRadioCom", "int"));
        $vehicle->sethasDigitalRadioCom($this->request->getPost("hasDigitalRadioCom", "int"));
        

        if (!$vehicle->save()) {
            foreach ($vehicle->getMessages() as $message) {
                $this->flash->error($message);
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

        $vehicle->setcreateTime($this->request->getPost("create_time", "int"));
        $vehicle->setupdateTime($this->request->getPost("update_time", "int"));
        $vehicle->setdescShort($this->request->getPost("desc_short", "int"));
        $vehicle->setdescLong($this->request->getPost("desc_long", "int"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "int"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance($this->request->getPost("isAmbulance", "int"));
        $vehicle->sethasFlashingLights($this->request->getPost("hasFlashingLights", "int"));
        $vehicle->sethasRadioCom($this->request->getPost("hasRadioCom", "int"));
        $vehicle->sethasDigitalRadioCom($this->request->getPost("hasDigitalRadioCom", "int"));
        

        if (!$vehicle->save()) {

            foreach ($vehicle->getMessages() as $message) {
                $this->flash->error($message);
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
                $this->flash->error($message);
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
