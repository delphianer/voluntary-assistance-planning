<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Volunteers;

class VolunteersController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "Search volunteers :: ");
    }

    /**
     * Searches for volunteers
     */
    public function searchAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Volunteers', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Volunteers',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any volunteers");

            $this->dispatcher->forward([
                "controller" => "volunteers",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found volunteers :: ");
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
        $this->view->setVar('extraTitle', "New Volunteers :: ");
    }

    /**
     * Edits a volunteer
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        if (!$this->request->isPost()) {
            $volunteer = Volunteers::findFirstByid($id);
            if (!$volunteer) {
                $this->flash->error("volunteer was not found");

                $this->dispatcher->forward([
                    'controller' => "volunteers",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $volunteer->getId();

            $this->tag->setDefault("id", $volunteer->getId());
            $this->tag->setDefault("create_time", $volunteer->getCreateTime());
            $this->tag->setDefault("update_time", $volunteer->getUpdateTime());
            $this->tag->setDefault("firstName", $volunteer->getFirstname());
            $this->tag->setDefault("lastName", $volunteer->getLastname());
            $this->tag->setDefault("userId", $volunteer->getUserid());
            $this->tag->setDefault("departmentId", $volunteer->getDepartmentid());
            
        }

        $this->view->setVar('extraTitle', "Edit Volunteers :: ");
    }

    /**
     * Creates a new volunteer
     */
    public function createAction()
    {
        $form = new UsersForm();

        if (!$this->request->isPost()) {
            // forward:
            //$this->dispatcher->forward([ 'controller' => "volunteers",'action' => 'index']);
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            //return;
        }

        $volunteer = new Volunteers();
        $volunteer->setcreateTime($this->request->getPost("create_time", "int"));
        $volunteer->setupdateTime($this->request->getPost("update_time", "int"));
        $volunteer->setfirstName($this->request->getPost("firstName", "int"));
        $volunteer->setlastName($this->request->getPost("lastName", "int"));
        $volunteer->setuserId($this->request->getPost("userId", "int"));
        $volunteer->setdepartmentId($this->request->getPost("departmentId", "int"));
        

        if (!$volunteer->save()) {
            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("volunteer was created successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a volunteer edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $volunteer = Volunteers::findFirstByid($id);

        if (!$volunteer) {
            $this->flash->error("volunteer does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        $volunteer->setcreateTime($this->request->getPost("create_time", "int"));
        $volunteer->setupdateTime($this->request->getPost("update_time", "int"));
        $volunteer->setfirstName($this->request->getPost("firstName", "int"));
        $volunteer->setlastName($this->request->getPost("lastName", "int"));
        $volunteer->setuserId($this->request->getPost("userId", "int"));
        $volunteer->setdepartmentId($this->request->getPost("departmentId", "int"));
        

        if (!$volunteer->save()) {

            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'edit',
                'params' => [$volunteer->getId()]
            ]);

            return;
        }

        $this->flash->success("volunteer was updated successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a volunteer
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $volunteer = Volunteers::findFirstByid($id);
        if (!$volunteer) {
            $this->flash->error("volunteer was not found");

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'index'
            ]);

            return;
        }

        if (!$volunteer->delete()) {

            foreach ($volunteer->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("volunteer was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers",
            'action' => "index"
        ]);
    }
}
