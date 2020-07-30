<?php


namespace Vokuro\Forms;


use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Clients;
use Vokuro\Models\Departments;
use Phalcon\Forms\Element\Select;
use Vokuro\Models\Locations;

class AppointmentsForm extends \Phalcon\Forms\Form
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


        $label = new Text('label', [
            'placeholder' => 'Label',
            'class' => 'form-control'
        ]);

        $label->addValidators([
            new PresenceOf([
                'message' => 'The label is required',
            ]),
        ]);

        $this->add($label);

        $this->add(new TextArea('description', [
            'placeholder' => 'Description',
            'class' => 'form-control'
        ]));


        $this->add(new Text('start', [
            'class' => 'form-control',
            'id' => 'startDateTimeField'
        ]));


        $this->add(new Text('end', [
            'class' => 'form-control',
            'id' => 'endDateTimeField'
        ]));


        $departments = Departments::find([]);

        $emptyDepartmentText = 'no main department';
        if ($currentAction == 'index') {
            $emptyDepartmentText = 'any department setting';
        }
        $emptyText = 'no department';
        if ($currentAction == 'index') {
            $emptyText = 'any department';
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


        $locations = Locations::find([]);

        $emptyText = 'no location';
        if ($currentAction == 'index') {
            $emptyText = 'any location';
        }

        $this->add(new Select('locationId', $locations, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => true,
            'emptyText'  => $emptyText,
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]));




        $clients = Clients::find([]);

        $emptyText = 'no client';
        if ($currentAction == 'index') {
            $emptyText = 'any client';
        }

        $clientId = new Select('clientId', $clients, [
            'using' => [
                'id',
                'label',
            ],
            'useEmpty' => true,
            'emptyText'  => $emptyText,
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]);

        $this->add($clientId);
    }

}
