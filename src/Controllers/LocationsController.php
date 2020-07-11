<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Locations;
use function Vokuro\getCurrentDateTimeStamp;

class LocationsController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search locations");
    }

    /**
     * Searches for locations
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Locations', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Locations',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any locations");

            $this->dispatcher->forward([
                "controller" => "locations",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found locations");
        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Locations");
    }

    /**
     * Edits a location
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $location = Locations::findFirstByid($id);
            if (!$location) {
                $this->flash->error("location was not found");

                $this->dispatcher->forward([
                    'controller' => "locations",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $location->getId();

            $this->tag->setDefault("id", $location->getId());
            $this->tag->setDefault("create_time", $location->getCreateTime());
            $this->tag->setDefault("update_time", $location->getUpdateTime());
            $this->tag->setDefault("label", $location->getLabel());
            $this->tag->setDefault("description", $location->getDescription());
            $this->tag->setDefault("street", $location->getStreet());
            $this->tag->setDefault("additionalText", $location->getAdditionaltext());
            $this->tag->setDefault("postalcode", $location->getPostalcode());
            $this->tag->setDefault("city", $location->getCity());
            $this->tag->setDefault("country", $location->getCountry());

        }

        $this->view->setVar('extraTitle', "Edit Locations");
    }

    /**
     * Creates a new location
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([ 'controller' => "locations",'action' => 'index']);
            return;
        }

        $location = new Locations();
        $this->setLocationDetails($location);


        if (!$location->save()) {
            foreach ($location->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("location was created successfully");

        $this->dispatcher->forward([
            'controller' => "locations",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a location edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $location = Locations::findFirstByid($id);

        if (!$location) {
            $this->flash->error("location does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'index'
            ]);

            return;
        }

        $location->setupdateTime(getCurrentDateTimeStamp());
        $this->setLocationDetails($location);


        if (!$location->save()) {

            foreach ($location->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'edit',
                'params' => [$location->getId()]
            ]);

            return;
        }

        $this->flash->success("location was updated successfully");

        $this->dispatcher->forward([
            'controller' => "locations",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a location
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $location = Locations::findFirstByid($id);
        if (!$location) {
            $this->flash->error("location was not found");

            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'index'
            ]);

            return;
        }

        if (!$location->delete()) {
            foreach ($location->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "locations",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("location was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "locations",
            'action' => "index"
        ]);
    }

    /**
     * @param $location
     */
    public function setLocationDetails($location): void
    {
        $location->setLabel($this->request->getPost("label", "string"));
        $location->setDescription($this->request->getPost("description", "string"));
        $location->setstreet($this->request->getPost("street", "string"));
        $location->setadditionalText($this->request->getPost("additionalText", "string"));
        $location->setpostalcode($this->request->getPost("postalcode", "string"));
        $location->setcity($this->request->getPost("city", "string"));
        $location->setcountry($this->request->getPost("country", "string"));
    }
}
