<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Forms\VehiclePropertiesForm;
use Vokuro\Models\Vehicleproperties;
use Vokuro\Models\Vehicles;
use function Vokuro\getCurrentDateTimeStamp;
use function Vokuro\translateFromYesNo;

class VehiclepropertiesController extends ControllerBase
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
        $form = new VehiclePropertiesForm();
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "Search vehicleproperties");
    }

    /**
     * Searches for vehicleproperties
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Vehicleproperties::class, $this->request->getQuery());
        $builder->orderBy("label");

        $count = Vehicleproperties::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any vehicleproperties');
            $this->dispatcher->forward([
                "controller" => "vehicleproperties",
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
        $this->view->setVar('extraTitle', "Found vehicleproperties");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $formOptions = [];
        $formOptions['selectedVehicle'] = $this->handleProcessVehicle(true);

        $form = new VehiclePropertiesForm(null, $formOptions);
        $this->view->setVar('form', $form);

        $this->view->setVar('extraTitle', "New Vehicleproperties");
    }

    /**
     * Edits a vehiclepropertie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $processVehiclesId = $this->dispatcher->getParam('processVehiclesId');
        if (isset($processVehiclesId)) {
            $id = $this->dispatcher->getParam('vehiclepropertyId');
        }
        if (!$this->request->isPost() || isset($processVehiclesId)) {
            $vehicleproperty = Vehicleproperties::findFirstByid($id);
            if (!$vehicleproperty) {
                $this->flash->error("vehiclepropertie was not found");

                $this->dispatcher->forward([
                    'controller' => "vehicleproperties",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $vehicleproperty->getId();

            $this->tag->setDefault("id", $vehicleproperty->getId());
            $this->tag->setDefault("vehiclesId", $vehicleproperty->getVehiclesid());
            $this->tag->setDefault("create_time", $vehicleproperty->getCreateTime());
            $this->tag->setDefault("update_time", $vehicleproperty->getUpdateTime());
            $this->tag->setDefault("label", $vehicleproperty->getLabel());
            $this->tag->setDefault("description", $vehicleproperty->getDescription());
            $this->tag->setDefault("is_numeric", $vehicleproperty->getIsNumeric());
            $this->tag->setDefault("value_string", $vehicleproperty->getValueString());
            $this->tag->setDefault("value_numeric", $vehicleproperty->getValueNumeric());

            $formOptions = [];
            $formOptions['selectedVehicle'] = $this->handleProcessVehicle(false);

            $form = new VehiclePropertiesForm(null, $formOptions);
            $this->view->setVar('form', $form);
        }

        $this->view->setVar('extraTitle', "Edit Vehicleproperties");
    }

    /**
     * Creates a new vehiclepropertie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "vehicleproperties",'action' => 'index']);
            return;
        }

        $vehicleproperty = new Vehicleproperties();
        $this->setVehiclePropertyDetails($vehicleproperty);

        if (!$vehicleproperty->save()) {
            foreach ($vehicleproperty->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("vehicleproperty was created successfully");

        $backActionValue = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($backActionValue)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "vehicleproperties",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a vehiclepropertie edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $vehiclepropertie = Vehicleproperties::findFirstByid($id);

        if (!$vehiclepropertie) {
            $this->flash->error("vehiclepropertie does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'index'
            ]);

            return;
        }

        $vehiclepropertie->setupdateTime(getCurrentDateTimeStamp());
        $this->setVehiclePropertyDetails($vehiclepropertie);


        if (!$vehiclepropertie->save()) {
            foreach ($vehiclepropertie->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'edit',
                'params' => [$vehiclepropertie->getId()]
            ]);

            return;
        }

        $this->flash->success("vehicleproperty was updated successfully");

        $backActionValue = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($backActionValue)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "vehicleproperties",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a vehiclepropertie
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        // passed by vehicle-dispatcher-forward:
        $processVehiclesId = $this->dispatcher->getParam('processVehiclesId');
        if (isset($processVehiclesId)) {
            $id = $this->dispatcher->getParam('vehiclepropertyId');
        }

        $vehicleproperty = Vehicleproperties::findFirstByid($id);
        if (!$vehicleproperty) {
            $this->flash->error("vehiclepropertie was not found");

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'index'
            ]);

            return;
        }

        if (!$vehicleproperty->delete()) {
            foreach ($vehicleproperty->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("vehicleproperty was deleted successfully");

        // go back to vehicle/edit/...
        if ($this->handledBackAction($processVehiclesId)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "vehicleproperties",
            'action' => "index"
        ]);
    }

    /**
     * @param $vehicleproperty
     */
    public function setVehiclePropertyDetails($vehicleproperty): void
    {
        $vehicleproperty->setvehiclesId($this->request->getPost("vehiclesId", "int"));
        $vehicleproperty->setLabel($this->request->getPost("label", "string"));
        $vehicleproperty->setDescription($this->request->getPost("description", "string"));
        $vehicleproperty->setisNumeric($this->request->getPost("is_numeric", "string"));
        $vehicleproperty->setvalueString($this->request->getPost("value_string", "string"));
        $vehicleproperty->setvalueNumeric($this->request->getPost("value_numeric", "float"));
    }

    /**
     * @param $isNewAction
     * @return array|null
     */
    private function handleProcessVehicle($isNewAction)
    {
        $processVehiclesId = $this->dispatcher->getParam('processVehiclesId');
        if (isset($processVehiclesId) && ($processVehiclesId > 0)) {
            $vehiclesLabel = $this->dispatcher->getParam('vehiclesLabel');
            $selectedVehicle = [
                'id'=>$processVehiclesId,
                'label'=>$vehiclesLabel,
            ];
            $this->view->setVar('selectedVehicle', $selectedVehicle);
            $this->view->setVar('backAction', 'vehicles/edit/'.$processVehiclesId);
            $this->view->setVar('backActionController', 'vehicles');
            $this->view->setVar('backActionValue', $processVehiclesId);
            if ($isNewAction) {
                $this->tag->setDefault("label", '');
                $this->tag->setDefault("description", '');
            }
            return $selectedVehicle;
        }
        return null;
    }

    private function handledBackAction($backActionValue)
    {
        if (isset($backActionValue)) {
            $this->tag->setDefault("id", $backActionValue);
            $this->dispatcher->setParam('processVehiclesId', $backActionValue);
            $this->dispatcher->forward([
                'controller' => 'vehicles',
                'action' => 'edit'
            ]);

            return true;
        }
        return false;
    }
}
