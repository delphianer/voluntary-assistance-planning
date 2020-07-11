<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Operations;
use function Vokuro\getCurrentDateTimeStamp;

class OperationsController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        // todo: check if private fits and remove this todo
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Search operations");
    }

    /**
     * Searches for operations
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Operations::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = Operations::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operations');
            $this->dispatcher->forward([
                "controller" => "operations",
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
        $this->view->setVar('extraTitle', "Found operations");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Operations");
    }

    /**
     * Edits a operation
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $operation = Operations::findFirstByid($id);
            if (!$operation) {
                $this->flash->error("operation was not found");

                $this->dispatcher->forward([
                    'controller' => "operations",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operation->getId();

            $this->tag->setDefault("id", $operation->getId());
            $this->tag->setDefault("clientId", $operation->getClientid());
            $this->tag->setDefault("create_time", $operation->getCreateTime());
            $this->tag->setDefault("create_userId", $operation->getCreateUserid());
            $this->tag->setDefault("update_time", $operation->getUpdateTime());
            $this->tag->setDefault("update_userId", $operation->getUpdateUserid());
            $this->tag->setDefault("shortDescription", $operation->getShortdescription());
            $this->tag->setDefault("longDescription", $operation->getLongdescription());
            $this->tag->setDefault("mainDepartmentId", $operation->getMaindepartmentid());
            
        }

        $this->view->setVar('extraTitle', "Edit Operations");
    }

    /**
     * Creates a new operation
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operations",'action' => 'index']);
            return;
        }

        $operation = new Operations();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operation->setclientId($this->request->getPost("clientId", "int"));
        $operation->setcreateTime($this->request->getPost("create_time", "int"));
        $operation->setcreateUserId($this->request->getPost("create_userId", "int"));
        $operation->setupdateTime($this->request->getPost("update_time", "int"));
        $operation->setupdateUserId($this->request->getPost("update_userId", "int"));
        $operation->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operation->setlongDescription($this->request->getPost("longDescription", "int"));
        $operation->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
        

        if (!$operation->save()) {
            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operation was created successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operation edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operation = Operations::findFirstByid($id);

        if (!$operation) {
            $this->flash->error("operation does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $operation->setupdateTime(getCurrentDateTimeStamp());
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operation->setclientId($this->request->getPost("clientId", "int"));
        $operation->setcreateTime($this->request->getPost("create_time", "int"));
        $operation->setcreateUserId($this->request->getPost("create_userId", "int"));
        $operation->setupdateTime($this->request->getPost("update_time", "int"));
        $operation->setupdateUserId($this->request->getPost("update_userId", "int"));
        $operation->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operation->setlongDescription($this->request->getPost("longDescription", "int"));
        $operation->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
        

        if (!$operation->save()) {

            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'edit',
                'params' => [$operation->getId()]
            ]);

            return;
        }

        $this->flash->success("operation was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operation
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operation = Operations::findFirstByid($id);
        if (!$operation) {
            $this->flash->error("operation was not found");

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operation->delete()) {

            foreach ($operation->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operations",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operation was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operations",
            'action' => "index"
        ]);
    }
}
