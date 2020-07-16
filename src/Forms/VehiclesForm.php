<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;

class VehiclesForm extends Form
{

    /**
     * @param null $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        // In edition the id is hidden
        if (!empty($options['editAction'])) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
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

        $this->add(new Text('technicalInspection', [
            'class' => 'form-control',
            'id' => 'techInspField'
        ]));

        $seatCount = new Text('seatCount', [
            'class' => 'form-control'
        ]);

        $seatCount->addValidators([
            new PresenceOf([
                'message' => 'The label is required',
            ]),
        ]);

        $seatCount->addValidators([
            new Numericality([ // RegexValidator
                'message' => 'The label is required',
                'allowEmpty' => false
            ]),
        ]);

        $this->add($seatCount);

        if (!empty($options['indexAction'])) {
            $yesNoFieldOptions = [
                ''=>'...',
                'N'=> 'No',
                'Y' => 'Yes',
            ];
        } else {
            $yesNoFieldOptions = [
                'N'=> 'No',
                'Y' => 'Yes',
            ];
        }

        $yesNoFieldAttributes = [
            'class' => 'form-control'
        ];

        $this->add(new Select('isAmbulance', $yesNoFieldOptions, $yesNoFieldAttributes));
        $this->add(new Select('hasFlashingLights', $yesNoFieldOptions, $yesNoFieldAttributes));
        $this->add(new Select('hasRadioCom', $yesNoFieldOptions, $yesNoFieldAttributes));
        $this->add(new Select('hasDigitalRadioCom', $yesNoFieldOptions, $yesNoFieldAttributes));
    }
}
