<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;
use Vokuro\Models\Certificates;

class CertificatesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for certificates
     */
    public function searchAction()
    {
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
     * Edits a certificate
     *
     * @param string $id
     */
    public function editAction($id)
    {
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

            $this->view->id = $certificate->id;

            $this->tag->setDefault("id", $certificate->id);
            $this->tag->setDefault("create_time", $certificate->create_time);
            $this->tag->setDefault("update_time", $certificate->update_time);
            $this->tag->setDefault("desc_short", $certificate->desc_short);
            $this->tag->setDefault("desc_long", $certificate->desc_long);
            
        }
    }

    /**
     * Creates a new certificate
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'index'
            ]);

            return;
        }

        $certificate = new Certificates();
        $certificate->createTime = $this->request->getPost("create_time", "int");
        $certificate->updateTime = $this->request->getPost("update_time", "int");
        $certificate->descShort = $this->request->getPost("desc_short", "int");
        $certificate->descLong = $this->request->getPost("desc_long", "int");
        

        if (!$certificate->save()) {
            foreach ($certificate->getMessages() as $message) {
                $this->flash->error($message);
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

        $certificate->createTime = $this->request->getPost("create_time", "int");
        $certificate->updateTime = $this->request->getPost("update_time", "int");
        $certificate->descShort = $this->request->getPost("desc_short", "int");
        $certificate->descLong = $this->request->getPost("desc_long", "int");
        

        if (!$certificate->save()) {

            foreach ($certificate->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "certificates",
                'action' => 'edit',
                'params' => [$certificate->id]
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
                $this->flash->error($message);
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
