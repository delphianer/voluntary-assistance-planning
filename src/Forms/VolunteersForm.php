<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
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
        // In edition the id is hidden
        if (!empty($options['edit'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $this->add($id);

        $firstName = new Text('firstName', [
            'placeholder' => 'First Name',
        ]);

        $firstName->addValidators([
            new PresenceOf([
                'message' => 'The first name is required',
            ]),
        ]);

        $this->add($firstName);

        $lastName = new Text('lastName', [
            'placeholder' => 'Last Name',
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
            ],
        ]);

        $this->add(new Select('userId', $users, [
            'using'      => [
                'id',
                'name',
            ],
            'useEmpty'   => true,
            'emptyText'  => 'No Account yet',
            'emptyValue' => '0',
        ]));

        $departments = Users::find([
            'active = :active:',
            'bind' => [
                'active' => 'Y',
            ],
        ]);

        $this->add(new Select('departmentId', $departments, [
            'using'      => [
                'id',
                'desc_short',
            ],
            'useEmpty'   => true,
            'emptyText'  => 'No Department yet',
            'emptyValue' => '0',
        ]));

        // todo-008: List Certificates from Link-Table

    }
}
