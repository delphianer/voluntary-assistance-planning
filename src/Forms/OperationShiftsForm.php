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
use Vokuro\Models\Equipment;
use Vokuro\Models\Locations;
use Vokuro\Models\Operations;

class OperationShiftsForm extends Form
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


        if (isset($options['selectedOperation'])) {
            $operationId = new Hidden('operationId');
            $operationId->setDefault($options['selectedOperation']['id']);
        } else {
            $operations = Operations::find([]);

            $useEmpty = false;
            if ($currentAction == 'index') {
                $useEmpty = true;
            }

            $operationId = new Select('operationId', $operations, [
                'using'      => [
                    'id',
                    'shortDescription',
                ],
                'useEmpty'   => $useEmpty,
                'emptyText'  => 'any operation',
                'emptyValue' => '',
                'class' => 'form-control  mr-sm-3'
            ]);
        }

        $operationId->addValidators([
            new PresenceOf([
                'message' => 'The short description is required',
            ]),
        ]);

        $this->add($operationId);



        $locations = Locations::find([]);

        $useEmpty = false;
        if ($currentAction == 'index') {
            $useEmpty = true;
        }

        $locationId = new Select('locationId', $locations, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => $useEmpty,
            'emptyText'  => 'any location',
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]);

        $this->add($locationId);



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



        $this->add(new Text('start', [
            'class' => 'form-control',
            'id' => 'startDateTimeField'
        ]));


        $this->add(new Text('end', [
            'class' => 'form-control',
            'id' => 'endDateTimeField'
        ]));




        // mini form for quickly adding equipment

        $this->add(new Hidden('volShEquLnkId'));

        $equipment = Equipment::find([]);

        $this->add(new Select('equipment', $equipment, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => false,
            'class' => 'form-control  mr-sm-3'
        ]));

        $this->add(new Text('equipShortDesc', [
            'class' => 'form-control  mr-sm-2'
        ]));

        $this->add(new Text('equipNeedCount', [
            'title' => 'needed count',
            'class' => 'form-control  mr-sm-2',
            'default' => '1'
        ]));
    }

}
