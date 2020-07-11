<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Operationshifts;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search operationshifts");
    }

    /**
     * Searches for operationshifts
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Operationshifts::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = Operationshifts::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts');
            $this->dispatcher->forward([
                "controller" => "operationshifts",
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
        $this->view->setVar('extraTitle', "Found operationshifts");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Operationshifts");
    }

    /**
     * Edits a operationshift
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $operationshift = Operationshifts::findFirstByid($id);
            if (!$operationshift) {
                $this->flash->error("operationshift was not found");

                $this->dispatcher->forward([
                    'controller' => "operationshifts",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operationshift->getId();

            $this->tag->setDefault("id", $operationshift->getId());
            $this->tag->setDefault("operationId", $operationshift->getOperationid());
            $this->tag->setDefault("locationId", $operationshift->getLocationid());
            $this->tag->setDefault("create_time", $operationshift->getCreateTime());
            $this->tag->setDefault("create_userId", $operationshift->getCreateUserid());
            $this->tag->setDefault("update_time", $operationshift->getUpdateTime());
            $this->tag->setDefault("update_userId", $operationshift->getUpdateUserid());
            $this->tag->setDefault("shortDescription", $operationshift->getShortdescription());
            $this->tag->setDefault("longDescription", $operationshift->getLongdescription());
            
        }

        $this->view->setVar('extraTitle', "Edit Operationshifts");
    }

    /**
     * Creates a new operationshift
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operationshifts",'action' => 'index']);
            return;
        }

        $operationshift = new Operationshifts();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshift->setoperationId($this->request->getPost("operationId", "int"));
        $operationshift->setlocationId($this->request->getPost("locationId", "int"));
        $operationshift->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshift->setcreateUserId($this->request->getPost("create_userId", "int"));
        $operationshift->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshift->setupdateUserId($this->request->getPost("update_userId", "int"));
        $operationshift->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshift->setlongDescription($this->request->getPost("longDescription", "int"));
        

        if (!$operationshift->save()) {
            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operationshift was created successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operationshift edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operationshift = Operationshifts::findFirstByid($id);

        if (!$operationshift) {
            $this->flash->error("operationshift does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $operationshift->setupdateTime(getCurrentDateTimeStamp());
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshift->setoperationId($this->request->getPost("operationId", "int"));
        $operationshift->setlocationId($this->request->getPost("locationId", "int"));
        $operationshift->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshift->setcreateUserId($this->request->getPost("create_userId", "int"));
        $operationshift->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshift->setupdateUserId($this->request->getPost("update_userId", "int"));
        $operationshift->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshift->setlongDescription($this->request->getPost("longDescription", "int"));
        

        if (!$operationshift->save()) {

            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'edit',
                'params' => [$operationshift->getId()]
            ]);

            return;
        }

        $this->flash->success("operationshift was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operationshift
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operationshift = Operationshifts::findFirstByid($id);
        if (!$operationshift) {
            $this->flash->error("operationshift was not found");

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operationshift->delete()) {

            foreach ($operationshift->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operationshift was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => "index"
        ]);
    }
}
