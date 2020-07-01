<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Models\Equipment;

class EquipmentController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for equipment
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Equipment', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Equipment',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any equipment");

            $this->dispatcher->forward([
                "controller" => "equipment",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //
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
    }

    /**
     * Creates a new equipment
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "equipment",
                'action' => 'index'
            ]);

            return;
        }

        $equipment = new Equipment();
        $equipment->setcreateTime($this->request->getPost("create_time", "int"));
        $equipment->setupdateTime($this->request->getPost("update_time", "int"));
        $equipment->setdescShort($this->request->getPost("desc_short", "int"));
        $equipment->setdescLong($this->request->getPost("desc_long", "int"));
        $equipment->settotalCount($this->request->getPost("total_count", "int"));
        

        if (!$equipment->save()) {
            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message);
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

        $equipment->setcreateTime($this->request->getPost("create_time", "int"));
        $equipment->setupdateTime($this->request->getPost("update_time", "int"));
        $equipment->setdescShort($this->request->getPost("desc_short", "int"));
        $equipment->setdescLong($this->request->getPost("desc_long", "int"));
        $equipment->settotalCount($this->request->getPost("total_count", "int"));
        

        if (!$equipment->save()) {

            foreach ($equipment->getMessages() as $message) {
                $this->flash->error($message);
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
                $this->flash->error($message);
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
}