<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Equipment;
use function Vokuro\getCurrentDateTimeStamp;

class EquipmentController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        $this->view->setTemplateBefore('private');
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Search equipment");
    }

    /**
     * Searches for equipment
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Equipment::class, $this->request->getQuery());
        $builder->orderBy("desc_short");

        $count = Equipment::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any equipment');
            $this->dispatcher->forward([
                "controller" => "equipment",
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
        $this->view->setVar('extraTitle', "Found equipment");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Equipment");
    }

    /**
     * Edits a equipment
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $equipment = Equipment::findFirstByid($id);
            if (!$equipment) {
                $this->flash->error("equipment was not found");

                $this->dispatcher->forward([
                    'controller' => "equipment",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $equipment->getId();
            $this->tag->setDefault("id", $equipment->getId());
            $this->tag->setDefault("create_time", $equipment->getCreateTime());
            $this->tag->setDefault("update_time", $equipment->getUpdateTime());
            $this->tag->setDefault("desc_short", $equipment->getDescShort());
            $this->tag->setDefault("desc_long", $equipment->getDescLong());
            $this->tag->setDefault("total_count", $equipment->getTotalCount());
        }

        $this->view->setVar('extraTitle', "Edit Equipment");
    }

    /**
     * Creates a new equipment
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "equipment",'action' => 'index']);
            return;
        }

        $equipment = new Equipment();
        $this->setEquipmentDetails($equipment);


        if (!$equipment->save()) {
            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("equipment was created successfully");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a equipment edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $equipment = Equipment::findFirstByid($id);

        if (!$equipment) {
            $this->flash->error("equipment does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $equipment->setupdateTime(getCurrentDateTimeStamp());
        $this->setEquipmentDetails($equipment);


        if (!$equipment->save()) {
            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'edit',
                'params' => [$equipment->getId()]
            ]);

            return;
        }

        $this->flash->success("equipment was updated successfully");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a equipment
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $equipment = Equipment::findFirstByid($id);
        if (!$equipment) {
            $this->flash->error("equipment was not found");

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        if (!$equipment->delete()) {
            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("equipment was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "equipment",
            'action' => "index"
        ]);
    }

    /**
     * @param Equipment $equipment
     */
    public function setEquipmentDetails(Equipment $equipment): void
    {
        $equipment->setdescShort($this->request->getPost("desc_short", "string"));
        $equipment->setdescLong($this->request->getPost("desc_long", "string"));
        $equipment->settotalCount($this->request->getPost("total_count", "int"));
    }
}
