<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Clients;
use function Vokuro\getCurrentDateTimeStamp;

class ClientsController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search clients");
    }

    /**
     * Searches for clients
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Clients::class, $this->request->getQuery());
        $builder->orderBy("label");

        $count = Clients::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any clients');
            $this->dispatcher->forward([
                "controller" => "clients",
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
        $this->view->setVar('extraTitle', "Found clients");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Clients");
    }

    /**
     * Edits a client
     *
     * @param string $id
     */
    public function editAction($id)
    {
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
            $this->tag->setDefault("label", $client->getLabel());
            $this->tag->setDefault("description", $client->getDescription());
            $this->tag->setDefault("contactInformation", $client->getContactinformation());
            
        }

        $this->view->setVar('extraTitle', "Edit Clients");
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
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
        $client->setLabel($this->request->getPost("label", "string"));
        $client->setDescription($this->request->getPost("description", "string"));
        $client->setcontactInformation($this->request->getPost("contactInformation", "string"));
    }
}
