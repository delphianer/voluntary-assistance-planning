<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Departments;
use function Vokuro\getCurrentDateTimeStamp;

class DepartmentsController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search departments");
    }

    /**
     * Searches for departments
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Departments::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("label");

        $count = Departments::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any departments');
            $this->dispatcher->forward([
                "controller" => "departments",
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
        $this->view->setVar('extraTitle', "Found departments");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Departments");
    }

    /**
     * Edits a department
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $department = Departments::findFirstByid($id);
            if (!$department) {
                $this->flash->error("department was not found");

                $this->dispatcher->forward([
                    'controller' => "departments",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $department->getId();

            $this->tag->setDefault("id", $department->getId());
            $this->tag->setDefault("create_time", $department->getCreateTime());
            $this->tag->setDefault("update_time", $department->getUpdateTime());
            $this->tag->setDefault("label", $department->getLabel());
            $this->tag->setDefault("description", $department->getDescription());
            
        }

        $this->view->setVar('extraTitle', "Edit Departments");
    }

    /**
     * Creates a new department
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "departments",'action' => 'index']);
            return;
        }

        $department = new Departments();
        $this->setDepartmentDetails($department);


        if (!$department->save()) {
            foreach ($department->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("department was created successfully");

        $this->dispatcher->forward([
            'controller' => "departments",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a department edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $department = Departments::findFirstByid($id);

        if (!$department) {
            $this->flash->error("department does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'index'
            ]);

            return;
        }

        $department->setupdateTime(getCurrentDateTimeStamp());
        $this->setDepartmentDetails($department);


        if (!$department->save()) {
            foreach ($department->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'edit',
                'params' => [$department->getId()]
            ]);

            return;
        }

        $this->flash->success("department was updated successfully");

        $this->dispatcher->forward([
            'controller' => "departments",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a department
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $department = Departments::findFirstByid($id);
        if (!$department) {
            $this->flash->error("department was not found");

            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'index'
            ]);

            return;
        }

        if (!$department->delete()) {
            foreach ($department->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "departments",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("department was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "departments",
            'action' => "index"
        ]);
    }

    /**
     * @param Departments $department
     */
    public function setDepartmentDetails(Departments $department): void
    {
        $department->setLabel($this->request->getPost("label", "string"));
        $department->setDescription($this->request->getPost("description", "string"));
    }
}
