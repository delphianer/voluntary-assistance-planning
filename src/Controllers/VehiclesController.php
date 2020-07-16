<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\DateTimePicker;
use Vokuro\Forms\VehiclesForm;
use Vokuro\Models\Vehicles;
use function Vokuro\getCurrentDateTimeStamp;

class VehiclesController extends ControllerBase
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
        $form = new VehiclesForm(null, ['indexAction' => true]);
        $this->view->setVar('form', $form);

        $this->setupDateTimePicker();

        $this->view->setVar('extraTitle', "Search vehicles");
    }

    /**
     * Searches for vehicles
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Vehicles::class, $this->request->getQuery());
        $builder->orderBy("label");

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
        $form = new VehiclesForm(null, ['newAction' => true]);
        $this->view->setVar('form', $form);

        $this->setupDateTimePicker();

        $this->view->setVar('extraTitle', "New Vehicles");
    }

    /**
     * Edits a vehicle
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $backActionVehiclesId = $this->dispatcher->getParam('processVehiclesId');
        if (isset($backActionVehiclesId)) {
            $id = $backActionVehiclesId;
        }
        if (!$this->request->isPost() || isset($backActionVehiclesId)) {
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
            $this->tag->setDefault("label", $vehicle->getLabel());
            $this->tag->setDefault("description", $vehicle->getDescription());
            $this->tag->setDefault("technicalInspection", $vehicle->getTechnicalinspection());
            $this->tag->setDefault("seatCount", $vehicle->getSeatcount());
            $this->tag->setDefault("isAmbulance", $vehicle->getIsambulance());
            $this->tag->setDefault("hasFlashingLights", $vehicle->getHasflashinglights());
            $this->tag->setDefault("hasRadioCom", $vehicle->getHasradiocom());
            $this->tag->setDefault("hasDigitalRadioCom", $vehicle->getHasdigitalradiocom());

            $form = new VehiclesForm(null, ['editAction' => true]);
            $this->view->setVars(
                [
                    'form' => $form,
                    'vehicle' => $vehicle
                ]
            );

            $this->setupDateTimePicker();

            $this->view->setVar('extraTitle', "Edit Vehicles");
        }
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

        if ($this->handledSubmitAction($this->request->getPost("submitAction"), $vehicle)) {
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
     * @param Vehicles $vehicle
     */
    public function setVehicleDetails($vehicle): void
    {
        $vehicle->setLabel($this->request->getPost("label", "string"));
        $vehicle->setDescription($this->request->getPost("description", "string"));
        $vehicle->settechnicalInspection($this->request->getPost("technicalInspection", "DateTime"));
        $vehicle->setseatCount($this->request->getPost("seatCount", "int"));
        $vehicle->setisAmbulance($this->request->getPost("isAmbulance", "string"));
        $vehicle->sethasFlashingLights($this->request->getPost("hasFlashingLights", "string"));
        $vehicle->sethasRadioCom($this->request->getPost("hasRadioCom", "string"));
        $vehicle->sethasDigitalRadioCom($this->request->getPost("hasDigitalRadioCom", "string"));
    }

    private function handledSubmitAction($submitAction, $vehicle)
    {
        if ($submitAction == 'submit') { // nothing to change
            return false;
        }

        // create new property
        if ($submitAction == 'goToProperty') {
            $this->dispatcher->setParam('processVehiclesId', $vehicle->getId());
            $this->dispatcher->setParam('vehiclesLabel', $vehicle->getLabel());
            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'new'
            ]);

            return true;
        }

        // edit existing property
        if (preg_match('/^edit\d/', $submitAction)) {
            $vehiclepropertyId = preg_replace('/^edit/', '', $submitAction);
            $this->dispatcher->setParam('processVehiclesId', $vehicle->getId());
            $this->dispatcher->setParam('vehiclesLabel', $vehicle->getLabel());
            $this->dispatcher->setParam('vehiclepropertyId', $vehiclepropertyId);
            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'edit'
            ]);

            return true;
        }

        // delete existing property
        if (preg_match('/^del\d/', $submitAction)) {
            $vehiclepropertyId = preg_replace('/^del/', '', $submitAction);
            $this->dispatcher->setParam('processVehiclesId', $vehicle->getId());
            $this->dispatcher->setParam('vehiclepropertyId', $vehiclepropertyId);
            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'delete'
            ]);

            return true;
        }
        return false;
    }
}
