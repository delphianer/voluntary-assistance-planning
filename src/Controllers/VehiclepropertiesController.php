<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Vehicleproperties;
use function Vokuro\getCurrentDateTimeStamp;
use function Vokuro\translateFromYesNo;

class VehiclepropertiesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "Search vehicleproperties");
    }

    /**
     * Searches for vehicleproperties
     */
    public function searchAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
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

        $this->view->setVar('extraTitle', "Found vehicleproperties");
        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "New Vehicleproperties");
    }

    /**
     * Edits a vehiclepropertie
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
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

        $this->view->setVar('extraTitle', "Edit Vehicleproperties");
    }

    /**
     * Creates a new vehiclepropertie
     */
    public function createAction()
    {
        // TODO-011: remove UserForm in multiple classes where not necessary
        $form = new UsersForm();

        if (!$this->request->isPost()) {
            // forward:
            //$this->dispatcher->forward([ 'controller' => "vehicleproperties",'action' => 'index']);
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            //return;
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
        $vehicleproperty->setdescShort($this->request->getPost("desc_short", "string"));
        $vehicleproperty->setdescLong($this->request->getPost("desc_long", "string"));
        $vehicleproperty->setisNumeric(translateFromYesNo($this->request->getPost("is_numeric", "string")));
        $vehicleproperty->setvalueString($this->request->getPost("value_string", "string"));
        $vehicleproperty->setvalueNumeric($this->request->getPost("value_numeric", "float"));
    }
}
