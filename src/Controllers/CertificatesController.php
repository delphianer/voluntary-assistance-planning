<?php
declare(strict_types=1);

//
namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\Certificates;
use function Vokuro\getCurrentDateTimeStamp;

class CertificatesController extends ControllerBase
{
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
        $this->view->setVar('extraTitle', "Search certificates");
    }

    /**
     * Searches for certificates
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), Certificates::class, $this->request->getQuery());
        $builder->orderBy("label");

        $count = Certificates::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any certificates');
            $this->dispatcher->forward([
                "controller" => "certificates",
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
        $this->view->setVar('extraTitle', "Found certificates");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New Certificates");
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

            $this->view->id = $certificate->getId();

            $this->tag->setDefault("id", $certificate->getId());
            $this->tag->setDefault("label", $certificate->getLabel());
            $this->tag->setDefault("description", $certificate->getDescription());

        }

        $this->view->setVar('extraTitle', "Edit Certificates");
    }

    /**
     * Creates a new certificate
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "certificates",'action' => 'index']);
            return;
        }

        $certificate = new Certificates();
        $certificate->setupdateTime(getCurrentDateTimeStamp());
        $certificate->setLabel($this->request->getPost("label", "string"));
        $certificate->setDescription($this->request->getPost("description", "string"));

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

        $certificate->setupdateTime(getCurrentDateTimeStamp());
        $certificate->setLabel($this->request->getPost("label", "string"));
        $certificate->setDescription($this->request->getPost("description", "string"));

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
