<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Appointments;
use function Vokuro\getCurrentDateTimeStamp;

class AppointmentsController extends ControllerBase
{
    /**
     * initialize this Controller
     */
    public function initialize()
    {
        // todo: check if private fits and remove this todo
        $this->view->setTemplateBefore('private');
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('extraTitle', "Search appointments");
    }

    /**
     * Searches for appointments
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Appointments::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = Appointments::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any appointments');
            $this->dispatcher->forward([
                "controller" => "appointments",
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
        $this->view->setVar('extraTitle', "Found appointments");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Appointments");
    }

    /**
     * Edits a appointment
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $appointment = Appointments::findFirstByid($id);
            if (!$appointment) {
                $this->flash->error("appointment was not found");

                $this->dispatcher->forward([
                    'controller' => "appointments",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $appointment->getId();

            $this->tag->setDefault("id", $appointment->getId());
            $this->tag->setDefault("create_time", $appointment->getCreateTime());
            $this->tag->setDefault("create_userId", $appointment->getCreateUserid());
            $this->tag->setDefault("update_time", $appointment->getUpdateTime());
            $this->tag->setDefault("update_userId", $appointment->getUpdateUserid());
            $this->tag->setDefault("label", $appointment->getLabel());
            $this->tag->setDefault("description", $appointment->getDescription());
            $this->tag->setDefault("start", $appointment->getStart());
            $this->tag->setDefault("end", $appointment->getEnd());
            $this->tag->setDefault("locationId", $appointment->getLocationid());
            $this->tag->setDefault("mainDepartmentId", $appointment->getMaindepartmentid());
            $this->tag->setDefault("clientId", $appointment->getClientid());
            
        }

        $this->view->setVar('extraTitle', "Edit Appointments");
    }

    /**
     * Creates a new appointment
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "appointments",'action' => 'index']);
            return;
        }

        $appointment = new Appointments();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $appointment->setupdateTime(getCurrentDateTimeStamp());
        $appointment->setcreateTime($this->request->getPost("create_time", "int"));
        $appointment->setcreateUserId($this->request->getPost("create_userId", "int"));
        $appointment->setupdateTime($this->request->getPost("update_time", "int"));
        $appointment->setupdateUserId($this->request->getPost("update_userId", "int"));
        $appointment->setlabel($this->request->getPost("label", "int"));
        $appointment->setdescription($this->request->getPost("description", "int"));
        $appointment->setstart($this->request->getPost("start", "int"));
        $appointment->setend($this->request->getPost("end", "int"));
        $appointment->setlocationId($this->request->getPost("locationId", "int"));
        $appointment->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
        $appointment->setclientId($this->request->getPost("clientId", "int"));
        

        if (!$appointment->save()) {
            foreach ($appointment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("appointment was created successfully");

        $this->dispatcher->forward([
            'controller' => "appointments",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a appointment edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $appointment = Appointments::findFirstByid($id);

        if (!$appointment) {
            $this->flash->error("appointment does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $appointment->setupdateTime(getCurrentDateTimeStamp());
        $appointment->setcreateTime($this->request->getPost("create_time", "int"));
        $appointment->setcreateUserId($this->request->getPost("create_userId", "int"));
        $appointment->setupdateTime($this->request->getPost("update_time", "int"));
        $appointment->setupdateUserId($this->request->getPost("update_userId", "int"));
        $appointment->setlabel($this->request->getPost("label", "int"));
        $appointment->setdescription($this->request->getPost("description", "int"));
        $appointment->setstart($this->request->getPost("start", "int"));
        $appointment->setend($this->request->getPost("end", "int"));
        $appointment->setlocationId($this->request->getPost("locationId", "int"));
        $appointment->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
        $appointment->setclientId($this->request->getPost("clientId", "int"));
        

        if (!$appointment->save()) {

            foreach ($appointment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'edit',
                'params' => [$appointment->getId()]
            ]);

            return;
        }

        $this->flash->success("appointment was updated successfully");

        $this->dispatcher->forward([
            'controller' => "appointments",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a appointment
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $appointment = Appointments::findFirstByid($id);
        if (!$appointment) {
            $this->flash->error("appointment was not found");

            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'index'
            ]);

            return;
        }

        if (!$appointment->delete()) {

            foreach ($appointment->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "appointments",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("appointment was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "appointments",
            'action' => "index"
        ]);
    }
}
