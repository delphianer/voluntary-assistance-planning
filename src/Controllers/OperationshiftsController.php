<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\DateTimePicker;
use Vokuro\Forms\OperationShiftsForm;
use Vokuro\Models\Operations;
use Vokuro\Models\Operationshifts;
use Vokuro\Models\OperationshiftsEquipmentLink;
use Vokuro\Models\OperationshiftsVehiclesLink;
use function Vokuro\getCurrentDateTimeStamp;

class OperationshiftsController extends ControllerBase
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
        $form = new OperationShiftsForm();
        $this->view->setVar('form', $form);

        $this->setupDateTimePicker();

        $this->view->setVar('extraTitle', "Search operationshifts");
    }

    /**
     * Searches for operationshifts
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Operationshifts::class, $this->request->getQuery());
        $builder->orderBy("start");

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
        $formOptions = [];
        $formOptions['selectedOperation'] = $this->handleProcessOperation(true, null);

        $form = new OperationShiftsForm(null, $formOptions);
        $this->view->setVar('form', $form);

        $this->setupDateTimePicker();

        $this->view->setVar('extraTitle', "New Operationshifts");
    }

    /**
     * Edits a operationshift
     *
     * @param string $id
     */
    public function editAction($id)
    {
        $processOperationId = $this->dispatcher->getParam('processOperationId');
        if (isset($processOperationId)) {
            $id = $this->dispatcher->getParam('OperationShiftsId');
        }
        if (!$this->request->isPost()|| isset($processOperationId)) {
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
            $this->tag->setDefault("start", $operationshift->getStart());
            $this->tag->setDefault("end", $operationshift->getEnd());

            $formOptions = [];
            $formOptions['selectedOperation'] = $this->handleProcessOperation(false, $operationshift);

            $form = new OperationShiftsForm(null, $formOptions);
            $this->view->setVar('form', $form);
            $this->view->setVar('operationshift', $operationshift);

            $opShEquLnkId = $this->dispatcher->getParam('opShEquLnkId');
            if (isset($opShEquLnkId) && ($opShEquLnkId > 0)) {
                $equiLink = OperationshiftsEquipmentLink::findFirstByid($opShEquLnkId);
                $this->tag->setDefault("opShEquLnkId", $equiLink->getId());
                $this->tag->setDefault("equipment", $equiLink->getEquipmentId());
                $this->tag->setDefault("equipShortDesc", $equiLink->getShortDescription());
                $this->tag->setDefault("equipNeedCount", $equiLink->getNeedCount());

                $this->view->setVar('setActiveTabKey', 'equipment');
            }

            $opShVehLnkId = $this->dispatcher->getParam('opShVehLnkId');
            if (isset($opShVehLnkId) && ($opShVehLnkId > 0)) {
                $vehiLink = OperationshiftsVehiclesLink::findFirstByid($opShVehLnkId);
                $this->tag->setDefault("opShVehLnkId", $vehiLink->getId());
                $this->tag->setDefault("vehicle", $vehiLink->getVehicleId());
                $this->tag->setDefault("vehicShortDesc", $vehiLink->getShortDescription());

                $this->view->setVar('setActiveTabKey', 'vehicles');
            }
            else {
                $this->tag->setDefault("opShVehLnkId", '');
                $this->tag->setDefault("vehicle", '');
                $this->tag->setDefault("vehicShortDesc", '');
            }

            $this->setupDateTimePicker();
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
        $operationshift->setupdateUserId($this->auth->getUser()->id);
        $operationshift->setcreateUserId($this->auth->getUser()->id);
        $this->setOperationShiftDetails($operationshift);


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

        $this->flash->success("Shift was created successfully");

        $backActionValue = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($backActionValue)) {
            return;
        }

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

        $operationshift->setupdateTime(getCurrentDateTimeStamp());
        $operationshift->setupdateUserId($this->auth->getUser()->id);
        $this->setOperationShiftDetails($operationshift);


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

        // first check if submitAction is used
        if ($this->handeledSubmitAction(($this->request->getPost("submitAction", "string")), $operationshift)) {
            return;
        }

        $this->flash->success("Shift was updated successfully");

        $backActionValue = $this->request->getPost("backActionValue", "int");
        if ($this->handledBackAction($backActionValue)) {
            return;
        }

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
        $processOperationId = $this->dispatcher->getParam('processOperationId');
        if (isset($processOperationId)) {
            $id = $this->dispatcher->getParam('OperationShiftsId');
        }

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

        $this->flash->success("Shift was deleted successfully");

        if ($this->handledBackAction($processOperationId)) {
            return;
        }

        $this->dispatcher->forward([
            'controller' => "operationshifts",
            'action' => "index"
        ]);
    }

    /**
     * @param Operationshifts $operationshift
     */
    public function setOperationShiftDetails(Operationshifts $operationshift): void
    {
        $operationshift->setoperationId($this->request->getPost("operationId", "int"));
        $operationshift->setlocationId($this->request->getPost("locationId", "int"));
        $operationshift->setshortDescription($this->request->getPost("shortDescription", "string"));
        $operationshift->setlongDescription($this->request->getPost("longDescription", "string"));
        $operationshift->setstart($this->request->getPost("start", "DateTime"));
        $operationshift->setend($this->request->getPost("end", "DateTime"));
    }


    /**
     * @param bool $isNewAction
     * @param Operationshifts $operationshift
     * @return array|null
     */
    private function handleProcessOperation(bool $isNewAction, Operationshifts $operationshift)
    {
        $opId = $this->dispatcher->getParam('processOperationId');
        if (isset($opId) && ($opId > 0)) {
            if (!isset($operationshift)) {
                $shortDescription = (Operations::findFirstByid($opId))->shortDescription;
            } else {
                $shortDescription = $operationshift->Operations->shortDescription;
            }
            $selectedOperation = [
                'id'=>$opId,
                'shortDescription'=>$shortDescription,
            ];
            $this->view->setVar('selectedOperation', $selectedOperation);
            $this->view->setVar('backAction', 'operations/edit/'.$selectedOperation['id']);
            $this->view->setVar('backActionController', 'operations');
            $this->view->setVar('backActionValue', $opId);
            if ($isNewAction) { // default blank -> new fields should be empty
                $this->tag->setDefault("shortDescription", '');
                $this->tag->setDefault("longDescription", '');
            }
            return $selectedOperation;
        }
        return null;
    }

    /**
     * @param $backActionValue
     * @return bool
     */
    private function handledBackAction($backActionValue)
    {
        if (isset($backActionValue)) {
            $this->tag->setDefault("id", $backActionValue);
            $this->dispatcher->setParam('processOperationsId', $backActionValue);
            $this->dispatcher->forward([
                'controller' => 'operations',
                'action' => 'edit'
            ]);

            return true;
        }
        return false;
    }

    /**
     * @param $submitAction
     * @param Operationshifts $operationshift
     * @return bool
     */
    private function handeledSubmitAction($submitAction, $operationshift)
    {
        if ($submitAction == 'submit') { // nothing to change
            return false;
        }

        $dispatcherForward = false;

        $dispatcherForward = $this->handleDepartmentProcessing($submitAction, $operationshift);

        $dispatcherForward = $dispatcherForward || $this->handleEquipmentProcessing($submitAction, $operationshift);

        $dispatcherForward = $dispatcherForward || $this->handleVehicleProcessing($submitAction, $operationshift);


        if ($dispatcherForward) {
            $this->dispatcher->setParam('processOperationId', $operationshift->getOperationId());
            $this->dispatcher->setParam('OperationShiftsId', $operationshift->getId());
            $this->dispatcher->forward([
                'controller' => "operationshifts",
                'action' => 'edit'
            ]);

            return true;
        }

        // nothing matched:
        return false;
    }

    /**
     * @param $submitAction
     * @param Operationshifts $operationshift
     * @return bool
     */
    private function handleDepartmentProcessing($submitAction, Operationshifts $operationshift)
    {
        // default
        $dispatcherForward = false;

        return $dispatcherForward;
    }


    /**
     * @param $submitAction
     * @param Operationshifts $operationshift
     * @return bool
     */
    private function handleEquipmentProcessing($submitAction, Operationshifts $operationshift): bool
    {
        // default
        $dispatcherForward = false;

        if ($submitAction == 'saveEquipDefinition') {
            $opShEquLnkId = $this->request->getPost("opShEquLnkId", "int");
            if (isset($opShEquLnkId) && ($opShEquLnkId > 0)) {
                $equiLink = OperationshiftsEquipmentLink::findFirstByid($opShEquLnkId);
            } else {
                $equiLink = new OperationshiftsEquipmentLink();
                $equiLink->setCreateTime(getCurrentDateTimeStamp());
            }
            $equiLink->setUpdateTime(getCurrentDateTimeStamp());
            $equiLink->setOperationShiftId($operationshift->getId());
            $equiLink->setEquipmentId($this->request->getPost("equipment", "int"));
            $equiLink->setShortDescription($this->request->getPost("equipShortDesc", "string"));
            $equiLink->setNeedCount($this->request->getPost("equipNeedCount", "int"));
            if (!$equiLink->save()) {
                foreach ($equiLink->getMessages() as $message) {
                    $this->flash->error($message->getMessage());
                }
            }

            $this->view->setVar('setActiveTabKey', 'equipment');
            $dispatcherForward = true;
        }

        // edit existing Equipment
        if (preg_match('/^equiEdit\d/', $submitAction)) {
            $opShEquLnkId = preg_replace('/^equiEdit/', '', $submitAction);
            $this->dispatcher->setParam('opShEquLnkId', $opShEquLnkId);

            $this->view->setVar('setActiveTabKey', 'equipment');
            $dispatcherForward = true;
        }

        // delete existing Equipment
        if (preg_match('/^equiDel\d/', $submitAction)) {
            $opShEquLnkId = preg_replace('/^equiDel/', '', $submitAction);

            if (isset($opShEquLnkId) && ($opShEquLnkId > 0)) {
                $equiLink = OperationshiftsEquipmentLink::findFirstByid($opShEquLnkId);
                if (!$equiLink->delete()) {
                    foreach ($equiLink->getMessages() as $message) {
                        $this->flash->error($message->getMessage());
                    }
                }
            }

            $this->view->setVar('setActiveTabKey', 'equipment');
            $dispatcherForward = true;
        }
        return $dispatcherForward;
    }

    private function handleVehicleProcessing($submitAction, Operationshifts $operationshift)
    {
        // default
        $dispatcherForward = false;

        if ($submitAction == 'saveVehicleDefinition') {
            $opShVehLnkId = $this->request->getPost("opShVehLnkId", "int");
            if (isset($opShVehLnkId) && ($opShVehLnkId > 0)) {
                $vehiLink = OperationshiftsVehiclesLink::findFirstByid($opShVehLnkId);
            } else {
                $vehiLink = new OperationshiftsVehiclesLink();
                $vehiLink->setCreateTime(getCurrentDateTimeStamp());
            }
            $vehiLink->setUpdateTime(getCurrentDateTimeStamp());
            $vehiLink->setOperationShiftId($operationshift->getId());
            $vehiLink->setVehicleId($this->request->getPost("vehicle", "int"));
            $vehiLink->setShortDescription($this->request->getPost("vehicShortDesc", "string"));
            if (!$vehiLink->save()) {
                foreach ($vehiLink->getMessages() as $message) {
                    $this->flash->error($message->getMessage());
                }
            }

            $this->view->setVar('setActiveTabKey', 'vehicles');
            $dispatcherForward = true;
        }

        // edit existing Vehicle
        if (preg_match('/^vehiEdit\d/', $submitAction)) {
            $opShVehLnkId = preg_replace('/^vehiEdit/', '', $submitAction);
            $this->dispatcher->setParam('opShVehLnkId', $opShVehLnkId);

            $this->view->setVar('setActiveTabKey', 'vehicles');
            $dispatcherForward = true;
        }

        // delete existing Vehicle
        if (preg_match('/^vehiDel\d/', $submitAction)) {
            $opShVehLnkId = preg_replace('/^equiDel/', '', $submitAction);

            if (isset($opShVehLnkId) && ($opShVehLnkId > 0)) {
                $vehiLink = OperationshiftsVehiclesLink::findFirstByid($opShVehLnkId);
                if (!$vehiLink->delete()) {
                    foreach ($vehiLink->getMessages() as $message) {
                        $this->flash->error($message->getMessage());
                    }
                }
            }

            $this->view->setVar('setActiveTabKey', 'vehicles');
            $dispatcherForward = true;
        }

        return $dispatcherForward;
    }
}
