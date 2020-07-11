<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\OperationshiftsEquipmentLink;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsEquipmentLinkController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search operationshifts_equipment_link");
    }

    /**
     * Searches for operationshifts_equipment_link
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), OperationshiftsEquipmentLink::class, $this->request->getQuery());
        $builder->orderBy("shortDescription");

        $count = OperationshiftsEquipmentLink::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any operationshifts_equipment_link');
            $this->dispatcher->forward([
                "controller" => "operationshifts_equipment_link",
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
        $this->view->setVar('extraTitle', "Found operationshifts_equipment_link");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New OperationshiftsEquipmentLink");
    }

    /**
     * Edits a operationshifts_equipment_link
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $operationshifts_equipment_link = OperationshiftsEquipmentLink::findFirstByid($id);
            if (!$operationshifts_equipment_link) {
                $this->flash->error("operationshifts_equipment_link was not found");

                $this->dispatcher->forward([
                    'controller' => "operationshifts_equipment_link",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $operationshifts_equipment_link->getId();

            $this->tag->setDefault("id", $operationshifts_equipment_link->getId());
            $this->tag->setDefault("operationShiftId", $operationshifts_equipment_link->getOperationshiftid());
            $this->tag->setDefault("equipmentId", $operationshifts_equipment_link->getEquipmentid());
            $this->tag->setDefault("create_time", $operationshifts_equipment_link->getCreateTime());
            $this->tag->setDefault("update_time", $operationshifts_equipment_link->getUpdateTime());
            $this->tag->setDefault("shortDescription", $operationshifts_equipment_link->getShortdescription());
            $this->tag->setDefault("longDescription", $operationshifts_equipment_link->getLongdescription());

        }

        $this->view->setVar('extraTitle', "Edit OperationshiftsEquipmentLink");
    }

    /**
     * Creates a new operationshifts_equipment_link
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "operationshifts_equipment_link",'action' => 'index']);
            return;
        }

        $operationshifts_equipment_link = new OperationshiftsEquipmentLink();
        $this->setDetails($operationshifts_equipment_link);


        if (!$operationshifts_equipment_link->save()) {
            foreach ($operationshifts_equipment_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("operationshifts_equipment_link was created successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_equipment_link",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a operationshifts_equipment_link edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $operationshifts_equipment_link = OperationshiftsEquipmentLink::findFirstByid($id);

        if (!$operationshifts_equipment_link) {
            $this->flash->error("operationshifts_equipment_link does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'index'
            ]);

            return;
        }

        $operationshifts_equipment_link->setupdateTime(getCurrentDateTimeStamp());
        $this->setDetails($operationshifts_equipment_link);


        if (!$operationshifts_equipment_link->save()) {

            foreach ($operationshifts_equipment_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'edit',
                'params' => [$operationshifts_equipment_link->getId()]
            ]);

            return;
        }

        $this->flash->success("operationshifts_equipment_link was updated successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_equipment_link",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a operationshifts_equipment_link
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $operationshifts_equipment_link = OperationshiftsEquipmentLink::findFirstByid($id);
        if (!$operationshifts_equipment_link) {
            $this->flash->error("operationshifts_equipment_link was not found");

            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'index'
            ]);

            return;
        }

        if (!$operationshifts_equipment_link->delete()) {

            foreach ($operationshifts_equipment_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "operationshifts_equipment_link",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("operationshifts_equipment_link was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "operationshifts_equipment_link",
            'action' => "index"
        ]);
    }

    /**
     * @param OperationshiftsEquipmentLink $operationshifts_equipment_link
     */
    public function setDetails(OperationshiftsEquipmentLink $operationshifts_equipment_link): void
    {
        $operationshifts_equipment_link->setoperationShiftId($this->request->getPost("operationShiftId", "int"));
        $operationshifts_equipment_link->setequipmentId($this->request->getPost("equipmentId", "int"));
        $operationshifts_equipment_link->setcreateTime($this->request->getPost("create_time", "int"));
        $operationshifts_equipment_link->setupdateTime($this->request->getPost("update_time", "int"));
        $operationshifts_equipment_link->setshortDescription($this->request->getPost("shortDescription", "int"));
        $operationshifts_equipment_link->setlongDescription($this->request->getPost("longDescription", "int"));
    }
}
