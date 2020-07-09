<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Clients;
use function Vokuro\getCurrentDateTimeStamp;

class ClientsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "Search clients");
    }

    /**
     * Searches for clients
     */
    public function searchAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Clients', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Clients',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any clients");

            $this->dispatcher->forward([
                "controller" => "clients",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found clients");
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
        $this->view->setVar('extraTitle', "New Clients");
    }

    /**
     * Edits a client
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        if (!$this->request->isPost()) {
            $client = Clients::findFirstByid($id);
            if (!$client) {
                $this->flash->error("client was not found");

                $this->dispatcher->forward([
                    'controller' => "clients",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $client->getId();

            $this->tag->setDefault("id", $client->getId());
            $this->tag->setDefault("create_time", $client->getCreateTime());
            $this->tag->setDefault("update_time", $client->getUpdateTime());
            $this->tag->setDefault("desc_short", $client->getDescShort());
            $this->tag->setDefault("desc_long", $client->getDescLong());
            $this->tag->setDefault("contactInformation", $client->getContactinformation());

        }

        $this->view->setVar('extraTitle', "Edit Clients");
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([ 'controller' => "clients",'action' => 'index']);
            return;
        }

        $client = new Clients();
        $this->setClientDetails($client);


        if (!$client->save()) {
            foreach ($client->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("client was created successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a client edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $client = Clients::findFirstByid($id);

        if (!$client) {
            $this->flash->error("client does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        $client->setupdateTime(getCurrentDateTimeStamp());
        $this->setClientDetails($client);


        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'edit',
                'params' => [$client->getId()]
            ]);

            return;
        }

        $this->flash->success("client was updated successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a client
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $client = Clients::findFirstByid($id);
        if (!$client) {
            $this->flash->error("client was not found");

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        if (!$client->delete()) {
            foreach ($client->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("client was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => "index"
        ]);
    }

    /**
     * @param Clients $client
     */
    public function setClientDetails(Clients $client): void
    {
        $client->setdescShort($this->request->getPost("desc_short", "string"));
        $client->setdescLong($this->request->getPost("desc_long", "string"));
        $client->setcontactInformation($this->request->getPost("contactInformation", "string"));
    }
}
