<?php
declare(strict_types=1);

//$namespace$
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
$useFullyQualifiedModelName$
use function Vokuro\getCurrentDateTimeStamp;

class $className$Controller extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search $plural$");
    }

    /**
     * Searches for $plural$
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), $className$::class, $this->request->getQuery());
        // todo: decide if id fits best sort criteria
        $builder->orderBy("id");

        $count = $className$::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any $plural$');
            $this->dispatcher->forward([
                "controller" => "$plural$",
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
        $this->view->setVar('extraTitle', "Found $plural$");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New $className$");
    }

    /**
     * Edits a $singular$
     *
     * @param string $pkVar$
     */
    public function editAction($pkVar$)
    {
        if (!$this->request->isPost()) {
            $singularVar$ = $className$::findFirstBy$pk$($pkVar$);
            if (!$singularVar$) {
                $this->flash->error("$singular$ was not found");

                $this->dispatcher->forward([
                    'controller' => "$plural$",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->$pk$ = $singularVar$->$pkGet$;

            $assignTagDefaults$
        }

        $this->view->setVar('extraTitle', "Edit $className$");
    }

    /**
     * Creates a new $singular$
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "$plural$",'action' => 'index']);
            return;
        }

        $singularVar$ = new $className$();
        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $assignInputFromRequestCreate$

        if (!$singularVar$->save()) {
            foreach ($singularVar$->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("$singular$ was created successfully");

        $this->dispatcher->forward([
            'controller' => "$plural$",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a $singular$ edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'index'
            ]);

            return;
        }

        $pkVar$ = $this->request->getPost("$pk$");
        $singularVar$ = $className$::findFirstBy$pk$($pkVar$);

        if (!$singularVar$) {
            $this->flash->error("$singular$ does not exist " . $pkVar$);

            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'index'
            ]);

            return;
        }

        // todo: change last update time, maybe delete create time
        // todo: refactor what can be refactored :)
        // $singularVar$->setupdateTime(getCurrentDateTimeStamp());
        // todo: check datatypes! they may be wrong (DevTools V4.0.3)
        $assignInputFromRequestUpdate$

        if (!$singularVar$->save()) {

            foreach ($singularVar$->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'edit',
                'params' => [$singularVar$->$pkGet$]
            ]);

            return;
        }

        $this->flash->success("$singular$ was updated successfully");

        $this->dispatcher->forward([
            'controller' => "$plural$",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a $singular$
     *
     * @param string $pkVar$
     */
    public function deleteAction($pkVar$)
    {
        $singularVar$ = $className$::findFirstBy$pk$($pkVar$);
        if (!$singularVar$) {
            $this->flash->error("$singular$ was not found");

            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'index'
            ]);

            return;
        }

        if (!$singularVar$->delete()) {

            foreach ($singularVar$->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "$plural$",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("$singular$ was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "$plural$",
            'action' => "index"
        ]);
    }
}
