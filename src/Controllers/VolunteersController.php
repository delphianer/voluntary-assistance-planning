<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Forms\VolunteersForm;
use Vokuro\Models\Volunteers;
use function Vokuro\getCurrentDateTimeStamp;

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
    public function newAction() // preparation of "create"-Process
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "New Volunteers :: ");

        $form = new VolunteersForm();
        $this->view->setVar('form', $form);
    }

    /**
     * Edits a volunteer
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $form = new VolunteersForm();
        $this->view->setVar('form', $form);

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
    public function createAction() // the other part is "newAction"
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([ 'controller' => "volunteers",'action' => 'index']);
        }

        $volunteer = new Volunteers();
        $this->setVolunteerDetails($volunteer);


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

        $volunteer->setupdateTime(getCurrentDateTimeStamp());
        $this->setVolunteerDetails($volunteer);


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

    /**
     * @param Volunteers $volunteer
     */
    public function setVolunteerDetails(Volunteers $volunteer): void
    {
        $volunteer->setfirstName($this->request->getPost("firstName", "string"));
        $volunteer->setlastName($this->request->getPost("lastName", "string"));
        $volunteer->setuserId($this->request->getPost("userId", "int"));
        $volunteer->setdepartmentId($this->request->getPost("departmentId", "int"));
    }
}
