<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use http\Client\Curl\User;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\DateTimePicker;
use Vokuro\Models\Appointments;
use function Vokuro\getCurrentDateTimeStamp;

class AppointmentsController extends ControllerBase
{
    use DateTimePicker;

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
        $this->view->setVar('extraTitle', "Search appointments");
        $this->setupDateTimePicker();
    }

    /**
     * Searches for appointments
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Appointments::class, $this->request->getQuery());
        if ($builder->getConditions() == null) { // no conditions? -> restrict to future-appointments
            $builder->conditions('start >= DATE_FORMAT(NOW(),\'%Y-%m-%d 00:00:00\')'); // in the future
        }
        $builder->orderBy("start");

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
        $this->setupDateTimePicker();
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
        $this->setupDateTimePicker();
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
        $appointment->setcreateUserId($this->auth->getUser()->id);
        $this->setAppointmentDetails($appointment);


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

        $appointment->setupdateTime(getCurrentDateTimeStamp());
        $this->setAppointmentDetails($appointment);


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

    /**
     * @param Appointments $appointment
     * @throws \Vokuro\Plugins\Auth\Exception
     */
    public function setAppointmentDetails(Appointments $appointment): void
    {
        $appointment->setupdateUserId($this->auth->getUser()->id);
        $appointment->setlabel($this->request->getPost("label", "string"));
        $appointment->setdescription($this->request->getPost("description", "string"));
        $appointment->setstart($this->request->getPost("start", "DateTime"));
        $appointment->setend($this->request->getPost("end", "DateTime"));
        $appointment->setlocationId($this->request->getPost("locationId", "int"));
        $appointment->setmainDepartmentId($this->request->getPost("mainDepartmentId", "int"));
        $appointment->setclientId($this->request->getPost("clientId", "int"));
    }
}
