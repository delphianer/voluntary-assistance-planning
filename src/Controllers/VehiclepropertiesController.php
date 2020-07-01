<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Models\Vehicleproperties;

class VehiclepropertiesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for vehicleproperties
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Vehicleproperties', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Vehicleproperties',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any vehicleproperties");

            $this->dispatcher->forward([
                "controller" => "vehicleproperties",
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
            $this->tag->setDefault("desc_short", $vehiclepropertie->getDescShort());
            $this->tag->setDefault("desc_long", $vehiclepropertie->getDescLong());
            $this->tag->setDefault("is_numeric", $vehiclepropertie->getIsNumeric());
            $this->tag->setDefault("value_string", $vehiclepropertie->getValueString());
            $this->tag->setDefault("value_numeric", $vehiclepropertie->getValueNumeric());
            
        }
    }

    /**
     * Creates a new vehiclepropertie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "vehicleproperties",
                'action' => 'index'
            ]);

            return;
        }

        $vehiclepropertie = new Vehicleproperties();
        $vehiclepropertie->setvehiclesId($this->request->getPost("vehiclesId", "int"));
        $vehiclepropertie->setcreateTime($this->request->getPost("create_time", "int"));
        $vehiclepropertie->setupdateTime($this->request->getPost("update_time", "int"));
        $vehiclepropertie->setdescShort($this->request->getPost("desc_short", "int"));
        $vehiclepropertie->setdescLong($this->request->getPost("desc_long", "int"));
        $vehiclepropertie->setisNumeric($this->request->getPost("is_numeric", "int"));
        $vehiclepropertie->setvalueString($this->request->getPost("value_string", "int"));
        $vehiclepropertie->setvalueNumeric($this->request->getPost("value_numeric", "int"));
        

        if (!$vehiclepropertie->save()) {
            foreach ($vehiclepropertie->getMessages() as $message) {
                $this->flash->error($message);
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

        $vehiclepropertie->setvehiclesId($this->request->getPost("vehiclesId", "int"));
        $vehiclepropertie->setcreateTime($this->request->getPost("create_time", "int"));
        $vehiclepropertie->setupdateTime($this->request->getPost("update_time", "int"));
        $vehiclepropertie->setdescShort($this->request->getPost("desc_short", "int"));
        $vehiclepropertie->setdescLong($this->request->getPost("desc_long", "int"));
        $vehiclepropertie->setisNumeric($this->request->getPost("is_numeric", "int"));
        $vehiclepropertie->setvalueString($this->request->getPost("value_string", "int"));
        $vehiclepropertie->setvalueNumeric($this->request->getPost("value_numeric", "int"));
        

        if (!$vehiclepropertie->save()) {

            foreach ($vehiclepropertie->getMessages() as $message) {
                $this->flash->error($message);
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
                $this->flash->error($message);
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
}
