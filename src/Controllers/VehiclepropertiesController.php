<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Vehicleproperties;
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
        $this->view->setVar('extraTitle', "New Vehicleproperties");
    }

    /**
     * Edits a vehiclepropertie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $vehiclepropertie = Vehicleproperties::findFirstByid($id);
            if (!$vehiclepropertie) {
                $this->flash->error("vehiclepropertie was not found");

                $this->dispatcher->forward([
                    'controller' => "vehicleproperties",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $vehiclepropertie->getId();

            $this->tag->setDefault("id", $vehiclepropertie->getId());
            $this->tag->setDefault("vehiclesId", $vehiclepropertie->getVehiclesid());
            $this->tag->setDefault("create_time", $vehiclepropertie->getCreateTime());
            $this->tag->setDefault("update_time", $vehiclepropertie->getUpdateTime());
            $this->tag->setDefault("label", $vehiclepropertie->getLabel());
            $this->tag->setDefault("description", $vehiclepropertie->getDescription());
            $this->tag->setDefault("is_numeric", $vehiclepropertie->getIsNumeric());
            $this->tag->setDefault("value_string", $vehiclepropertie->getValueString());
            $this->tag->setDefault("value_numeric", $vehiclepropertie->getValueNumeric());
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

        $vehiclepropertie = new Vehicleproperties();
        $this->setVehiclePropertyDetails($vehiclepropertie);


        if (!$vehiclepropertie->save()) {
            foreach ($vehiclepropertie->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("vehiclepropertie was created successfully");

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

        $this->flash->success("vehiclepropertie was updated successfully");

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
        $vehiclepropertie = Vehicleproperties::findFirstByid($id);
        if (!$vehiclepropertie) {
            $this->flash->error("vehiclepropertie was not found");

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'index'
            ]);

            return;
        }

        if (!$vehiclepropertie->delete()) {
            foreach ($vehiclepropertie->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("vehiclepropertie was deleted successfully");

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
        $vehicleproperty->setisNumeric(translateFromYesNo($this->request->getPost("is_numeric", "string")));
        $vehicleproperty->setvalueString($this->request->getPost("value_string", "string"));
        $vehicleproperty->setvalueNumeric($this->request->getPost("value_numeric", "float"));
    }
}
