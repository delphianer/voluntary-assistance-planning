<?php
declare(strict_types=1);

//$namespace$
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
$useFullyQualifiedModelName$

class $className$Controller extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "Search $plural$");
    }

    /**
     * Searches for $plural$
     */
    public function searchAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '$fullyQualifiedModelName$', $_GET)->getParams();
        $parameters['order'] = "$pk$";

        $paginator   = new Model(
            [
                'model'      => '$fullyQualifiedModelName$',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any $plural$");

            $this->dispatcher->forward([
                "controller" => "$plural$",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found $plural$");
        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "New $className$");
    }

    /**
     * Edits a $singular$
     *
     * @param string $pkVar$
     */
    public function editAction($pkVar$)
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
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
        $form = new UsersForm();

        if (!$this->request->isPost()) {
            // forward:
            //$this->dispatcher->forward([ 'controller' => "$plural$",'action' => 'index']);
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            //return;
        }

        $singularVar$ = new $className$();
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
