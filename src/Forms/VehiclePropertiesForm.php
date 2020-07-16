<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

class VehiclePropertiesForm extends Form
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

        if (isset($options['selectedVehicle'])) {
            $vehiclesId = new Hidden('vehiclesId');
            $vehiclesId->setDefault($options['selectedVehicle']['id']);
        } else {
            $vehiclesId = new Text(
                'vehiclesId',
                ['class' => 'form-control']
            );
        }
        $this->add($vehiclesId);

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

        $isNumOptions = [
            'N' => 'Text Value',
            'Y' => 'Numeric Value'
        ];

        $isNumAttributes = [
            'class' => 'form-control'
        ];

        $this->add(new Select('is_numeric', $isNumOptions, $isNumAttributes));

        $this->add(new Text('value_string', ['class' => 'form-control']));

        $this->add(new Text('value_numeric', ['class' => 'form-control']));
    }
}
