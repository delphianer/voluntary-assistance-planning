<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\OperationshiftsDepartmentsLink;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsDepartmentsLinkController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search operationshifts_departments_link");
    }

    /**
     * Searches for operationshifts_departments_link
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), OperationshiftsDepartmentsLink::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = OperationshiftsDepartmentsLink::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts_departments_link');
            $this->dispatcher->forward([
                "controller" => "operationshifts_departments_link",
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
        $this->view->setVar('extraTitle', "Found operationshifts_departments_link");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New OperationshiftsDepartmentsLink");
    }

    /**
     * Edits a operationshifts_departments_link
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $operationshifts_departments_link = OperationshiftsDepartmentsLink::findFirstByid($id);
            if (!$operationshifts_departments_link) {
                $this->flash->error("operationshifts_departments_link was not found");

                $this->dispatcher->forward([
                    'controller' => "operationshifts_departments_link",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operationshifts_departments_link->getId();

            $this->tag->setDefault("id", $operationshifts_departments_link->getId());
            $this->tag->setDefault("operationShiftId", $operationshifts_departments_link->getOperationshiftid());
            $this->tag->setDefault("departmentId", $operationshifts_departments_link->getDepartmentid());
            $this->tag->setDefault("create_time", $operationshifts_departments_link->getCreateTime());
            $this->tag->setDefault("update_time", $operationshifts_departments_link->getUpdateTime());
            $this->tag->setDefault("shortDescription", $operationshifts_departments_link->getShortdescription());
            $this->tag->setDefault("longDescription", $operationshifts_departments_link->getLongdescription());
            $this->tag->setDefault("numberVolunteersNeeded", $operationshifts_departments_link->getNumbervolunteersneeded());
            $this->tag->setDefault("minimumCertificateRanking", $operationshifts_departments_link->getMinimumcertificateranking());
            
        }

        $this->view->setVar('extraTitle', "Edit OperationshiftsDepartmentsLink");
    }

    /**
     * Creates a new operationshifts_departments_link
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operationshifts_departments_link",'action' => 'index']);
            return;
        }

        $operationshifts_departments_link = new OperationshiftsDepartmentsLink();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshifts_departments_link->setoperationShiftId($this->request->getPost("operationShiftId", "int"));
        $operationshifts_departments_link->setdepartmentId($this->request->getPost("departmentId", "int"));
        $operationshifts_departments_link->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshifts_departments_link->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshifts_departments_link->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshifts_departments_link->setlongDescription($this->request->getPost("longDescription", "int"));
        $operationshifts_departments_link->setnumberVolunteersNeeded($this->request->getPost("numberVolunteersNeeded", "int"));
        $operationshifts_departments_link->setminimumCertificateRanking($this->request->getPost("minimumCertificateRanking", "int"));
        

        if (!$operationshifts_departments_link->save()) {
            foreach ($operationshifts_departments_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operationshifts_departments_link was created successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_departments_link",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operationshifts_departments_link edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operationshifts_departments_link = OperationshiftsDepartmentsLink::findFirstByid($id);

        if (!$operationshifts_departments_link) {
            $this->flash->error("operationshifts_departments_link does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $operationshifts_departments_link->setupdateTime(getCurrentDateTimeStamp());
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $operationshifts_departments_link->setoperationShiftId($this->request->getPost("operationShiftId", "int"));
        $operationshifts_departments_link->setdepartmentId($this->request->getPost("departmentId", "int"));
        $operationshifts_departments_link->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshifts_departments_link->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshifts_departments_link->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshifts_departments_link->setlongDescription($this->request->getPost("longDescription", "int"));
        $operationshifts_departments_link->setnumberVolunteersNeeded($this->request->getPost("numberVolunteersNeeded", "int"));
        $operationshifts_departments_link->setminimumCertificateRanking($this->request->getPost("minimumCertificateRanking", "int"));
        

        if (!$operationshifts_departments_link->save()) {

            foreach ($operationshifts_departments_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'edit',
                'params' => [$operationshifts_departments_link->getId()]
            ]);

            return;
        }

        $this->flash->success("operationshifts_departments_link was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_departments_link",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operationshifts_departments_link
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operationshifts_departments_link = OperationshiftsDepartmentsLink::findFirstByid($id);
        if (!$operationshifts_departments_link) {
            $this->flash->error("operationshifts_departments_link was not found");

            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operationshifts_departments_link->delete()) {

            foreach ($operationshifts_departments_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_departments_link",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operationshifts_departments_link was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_departments_link",
            'action' => "index"
        ]);
    }
}
