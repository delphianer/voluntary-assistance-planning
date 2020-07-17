<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Clients;
use Vokuro\Models\Departments;

class OperationsForm extends Form
{
    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        $currentAction = $this->dispatcher->getActionName();

        if ($currentAction == 'edit') {
            $id = new Hidden('id');
        } else {
            $id = new Text('id', [
                'placeholder' => 'Id',
                'class' => 'form-control'
            ]);
        }

        $this->add($id);



        $clients = Clients::find([]);

        $emptyClient = false;
        if ($currentAction == 'index') {
            $emptyClient = true;
        }

        $clientId = new Select('clientId', $clients, [
            'using' => [
                'id',
                'label',
            ],
            'useEmpty' => $emptyClient,
            'emptyText'  => 'any client',
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]);

        $clientId->addValidators([
            new PresenceOf([
                'message' => 'The client is required',
            ]),
        ]);

        $this->add($clientId);


        $shortDescription = new Text('shortDescription', [
            //'placeholder' => 'short description',
            'class' => 'form-control'
        ]);

        $shortDescription->addValidators([
            new PresenceOf([
                'message' => 'The short description is required',
            ]),
        ]);

        $this->add($shortDescription);


        $this->add(new TextArea('longDescription', [
            //'placeholder' => 'description',
            'class' => 'form-control'
        ]));


        $departments = Departments::find([]);

        $emptyDepartmentText = 'no main department';
        if ($currentAction == 'index') {
            $emptyDepartmentText = 'any department setting';
        }

        $this->add(new Select('mainDepartmentId', $departments, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => true,
            'emptyText'  => $emptyDepartmentText,
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]));
    }
}
