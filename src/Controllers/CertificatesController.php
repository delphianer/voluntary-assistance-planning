<?php
declare(strict_types=1);

// 
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Forms\UsersForm;
use Vokuro\Models\Certificates;

class CertificatesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $this->view->setVar('extraTitle', "Search certificates :: ");
    }

    /**
     * Searches for certificates
     */
    public function searchAction()
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, '\Vokuro\Models\Certificates', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => '\Vokuro\Models\Certificates',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any certificates");

            $this->dispatcher->forward([
                "controller" => "certificates",
                "action" => "index"
            ]);

            return;
        }

        $this->view->setVar('extraTitle', "Found certificates :: ");
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
        $this->view->setVar('extraTitle', "New Certificates :: ");
    }

    /**
     * Edits a certificate
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if ($this->session->has('auth-identity')) {
            $this->view->setTemplateBefore('private');
        }
        if (!$this->request->isPost()) {
            $certificate = Certificates::findFirstByid($id);
            if (!$certificate) {
                $this->flash->error("certificate was not found");

                $this->dispatcher->forward([
                    'controller' => "certificates",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $certificate->getId();

            $this->tag->setDefault("id", $certificate->getId());
            $this->tag->setDefault("create_time", $certificate->getCreateTime());
            $this->tag->setDefault("update_time", $certificate->getUpdateTime());
            $this->tag->setDefault("desc_short", $certificate->getDescShort());
            $this->tag->setDefault("desc_long", $certificate->getDescLong());
            
        }

        $this->view->setVar('extraTitle', "Edit Certificates :: ");
    }

    /**
     * Creates a new certificate
     */
    public function createAction()
    {
        $form = new UsersForm();

        if (!$this->request->isPost()) {
            // forward:
            //$this->dispatcher->forward([ 'controller' => "certificates",'action' => 'index']);
            foreach ($form->getMessages() as $message) {
                $this->flash->error((string) $message);
            }
            //return;
        }

        $certificate = new Certificates();
        $certificate->setcreateTime($this->request->getPost("create_time", "int"));
        $certificate->setupdateTime($this->request->getPost("update_time", "int"));
        $certificate->setdescShort($this->request->getPost("desc_short", "int"));
        $certificate->setdescLong($this->request->getPost("desc_long", "int"));
        

        if (!$certificate->save()) {
            foreach ($certificate->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("certificate was created successfully");

        $this->dispatcher->forward([
            'controller' => "certificates",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a certificate edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $certificate = Certificates::findFirstByid($id);

        if (!$certificate) {
            $this->flash->error("certificate does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'index'
            ]);

            return;
        }

        $certificate->setcreateTime($this->request->getPost("create_time", "int"));
        $certificate->setupdateTime($this->request->getPost("update_time", "int"));
        $certificate->setdescShort($this->request->getPost("desc_short", "int"));
        $certificate->setdescLong($this->request->getPost("desc_long", "int"));
        

        if (!$certificate->save()) {

            foreach ($certificate->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'edit',
                'params' => [$certificate->getId()]
            ]);

            return;
        }

        $this->flash->success("certificate was updated successfully");

        $this->dispatcher->forward([
            'controller' => "certificates",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a certificate
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $certificate = Certificates::findFirstByid($id);
        if (!$certificate) {
            $this->flash->error("certificate was not found");

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'index'
            ]);

            return;
        }

        if (!$certificate->delete()) {

            foreach ($certificate->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("certificate was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "certificates",
            'action' => "index"
        ]);
    }
}
