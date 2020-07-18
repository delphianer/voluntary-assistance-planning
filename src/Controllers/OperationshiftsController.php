<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\DateTimePicker;
use Vokuro\Forms\OperationShiftsForm;
use Vokuro\Models\Operationshifts;
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
        $formOptions['selectedOperation'] = $this->handleProcessOperation(true);

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
            $formOptions['selectedOperation'] = $this->handleProcessOperation(false);

            $form = new OperationShiftsForm(null, $formOptions);
            $this->view->setVar('form', $form);
            $this->view->setVar('operationshift', $operationshift);

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
     * @return array|null
     */
    private function handleProcessOperation(bool $isNewAction)
    {
        $opId = $this->dispatcher->getParam('processOperationId');
        if (isset($opId) && ($opId > 0)) {
            $label = $this->dispatcher->getParam('OperationShortDesc');
            $selectedOperation = [
                'id'=>$opId,
                'shortDescription'=>$label,
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

    private function handeledSubmitAction($submitAction, $operationshift)
    {
        if ($submitAction == 'submit') { // nothing to change
            return false;
        }

        // todo: saveEquipDefinition

        // nothing matched:
        return false;
    }
}
