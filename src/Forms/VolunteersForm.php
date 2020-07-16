<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Certificates;
use Vokuro\Models\Departments;
use Vokuro\Models\Profiles;
use Vokuro\Models\Users;

class VolunteersForm extends Form
{

    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        $currentAction = $this->dispatcher->getActionName();

        // In edition the id is hidden
        if ($currentAction == 'edit') {
            $id = new Hidden('id');
        } else { // search
            $id = new Text('id', [
                'placeholder' => 'Id',
                'class' => 'form-control'
            ]);
        }

        $this->add($id);

        $firstName = new Text('firstName', [
            'placeholder' => 'First Name',
            'class' => 'form-control'
        ]);

        $firstName->addValidators([
            new PresenceOf([
                'message' => 'The first name is required',
            ]),
        ]);

        $this->add($firstName);

        $lastName = new Text('lastName', [
            'placeholder' => 'Last Name',
            'class' => 'form-control'
        ]);

        $lastName->addValidators([
            new PresenceOf([
                'message' => 'The last name is required',
            ]),
        ]);

        $this->add($lastName);

        $users = Users::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ]
        ]);

        $this->add(new Select('userId', $users, [
            'using'      => [
                'id',
                'name',
            ],
            'useEmpty'   => true,
            'emptyText'  => 'No Account yet',
            'emptyValue' => '',
                'class' => 'form-control'
        ]));

        $departments = Departments::find([]);

        $this->add(new Select('departmentId', $departments, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => true,
            'emptyText'  => 'No Department yet',
            'emptyValue' => '',
            'class' => 'form-control'
        ]));

        // mini form for editing certificates

        $this->add(new Hidden('volCertLnkId'));

        $certificates = Certificates::find([]);

        $this->add(new Select('certificate', $certificates, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => false,
            'class' => 'form-control  mr-sm-3'
        ]));

        $this->add(new Text('certValidUntil', [
            'placeholder' => 'Valid Until Date',
            'class' => 'form-control  mr-sm-3',
            'id' => 'certValidUntil'
        ]));

        // todo-008: List Certificates from Link-Table
    }
}
