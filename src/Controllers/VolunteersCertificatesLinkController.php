<?php
declare(strict_types=1);

namespace Vokuro\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\QueryBuilder as Paginator;
use Vokuro\Models\VolunteersCertificatesLink;
use function Vokuro\getCurrentDateTimeStamp;

class VolunteersCertificatesLinkController extends ControllerBase
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
        $this->view->setVar('extraTitle', "Search Certificate-Setup");
    }

    /**
     * Searches for volunteers_certificates_link
     */
    public function searchAction()
    {
        $builder = Criteria::fromInput($this->getDI(), VolunteersCertificatesLink::class, $this->request->getQuery());
        $builder->orderBy("validUntil desc");

        $count = VolunteersCertificatesLink::count($builder->getParams());
        if ($count === 0) {
            $this->flash->notice('The search did not find any volunteers_certificates_link');
            $this->dispatcher->forward([
                "controller" => "volunteers_certificates_link",
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
        $this->view->setVar('extraTitle', "Found volunteers_certificates_link");
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('extraTitle', "New VolunteersCertificatesLink");
    }

    /**
     * Edits a volunteers_certificates_link
     *
     * @param string $create_time
     */
    public function editAction($create_time)
    {
        if (!$this->request->isPost()) {
            $volunteers_certificates_link = VolunteersCertificatesLink::findFirstBycreate_time($create_time);
            if (!$volunteers_certificates_link) {
                $this->flash->error("volunteers_certificates_link was not found");

                $this->dispatcher->forward([
                    'controller' => "volunteers_certificates_link",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->create_time = $volunteers_certificates_link->getCreateTime();

            $this->tag->setDefault("create_time", $volunteers_certificates_link->getCreateTime());
            $this->tag->setDefault("update_time", $volunteers_certificates_link->getUpdateTime());
            $this->tag->setDefault("volunteersId", $volunteers_certificates_link->getVolunteersid());
            $this->tag->setDefault("certificatesId", $volunteers_certificates_link->getCertificatesid());
            $this->tag->setDefault("validUntil", $volunteers_certificates_link->getValiduntil());

        }

        $this->view->setVar('extraTitle', "Edit VolunteersCertificatesLink");
    }

    /**
     * Creates a new volunteers_certificates_link
     */
    public function createAction()
    {
        if (!$this->request->isPost()) { // post should go to NewAction
            $this->dispatcher->forward([ 'controller' => "volunteers_certificates_link",'action' => 'index']);
            return;
        }

        $volunteers_certificates_link = new VolunteersCertificatesLink();
        $this->setTableDetails($volunteers_certificates_link);


        if (!$volunteers_certificates_link->save()) {
            foreach ($volunteers_certificates_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("volunteers_certificates_link was created successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers_certificates_link",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a volunteers_certificates_link edited
     *
     */
    public function saveAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'index'
            ]);

            return;
        }

        $create_time = $this->request->getPost("create_time");
        $volunteers_certificates_link = VolunteersCertificatesLink::findFirstBycreate_time($create_time);

        if (!$volunteers_certificates_link) {
            $this->flash->error("volunteers_certificates_link does not exist " . $create_time);

            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'index'
            ]);

            return;
        }

        $volunteers_certificates_link->setupdateTime(getCurrentDateTimeStamp());
        $this->setTableDetails($volunteers_certificates_link);


        if (!$volunteers_certificates_link->save()) {

            foreach ($volunteers_certificates_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'edit',
                'params' => [$volunteers_certificates_link->getCreateTime()]
            ]);

            return;
        }

        $this->flash->success("volunteers_certificates_link was updated successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers_certificates_link",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a volunteers_certificates_link
     *
     * @param string $create_time
     */
    public function deleteAction($create_time)
    {
        $volunteers_certificates_link = VolunteersCertificatesLink::findFirstBycreate_time($create_time);
        if (!$volunteers_certificates_link) {
            $this->flash->error("volunteers_certificates_link was not found");

            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'index'
            ]);

            return;
        }

        if (!$volunteers_certificates_link->delete()) {

            foreach ($volunteers_certificates_link->getMessages() as $message) {
                $this->flash->error($message->getMessage());
            }

            $this->dispatcher->forward([
                'controller' => "volunteers_certificates_link",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("volunteers_certificates_link was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "volunteers_certificates_link",
            'action' => "index"
        ]);
    }

    /**
     * @param VolunteersCertificatesLink $volunteers_certificates_link
     */
    public function setTableDetails(VolunteersCertificatesLink $volunteers_certificates_link): void
    {
        $volunteers_certificates_link->setvolunteersId($this->request->getPost("volunteersId", "int"));
        $volunteers_certificates_link->setcertificatesId($this->request->getPost("certificatesId", "int"));
        $volunteers_certificates_link->setvalidUntil($this->request->getPost("validUntil", "int"));
    }
}
