<?php


namespace Vokuro\Forms;

use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Vokuro\Models\Certificates;
use Vokuro\Models\Operationshifts;
use Vokuro\Models\OperationshiftsDepartmentsLink;
use Vokuro\Models\OpshdeplVolunteersLink;
use Vokuro\Models\Volunteers;
use Vokuro\Models\VolunteersCertificatesLink;

class VolunteersCommitmentForm extends Form
{
    /**
     * @param OpshdeplVolunteersLink $entity
     * @param array $options
     */
    public function initialize($entity = null, array $options = [])
    {
        /**
         * @var Operationshifts $operationShift
         * @var OperationshiftsDepartmentsLink $operationShiftDepartmentNeeds
         * @var Volunteers $volunteer
         */
        $currentAction = $this->dispatcher->getActionName();
        $operationShift = array_key_exists('operationShift', $options) ? $options['operationShift'] : null;
        $operationShiftDepartmentNeeds = array_key_exists('operationShiftDepartmentNeeds', $options) ? $options['operationShiftDepartmentNeeds'] : null;
        $volunteer = array_key_exists('volunteer', $options) ? $options['volunteer'] : null;

        if ($currentAction == 'edit') {
            $id = new Hidden('id');
        } else {
            $id = new Text('id', [
                'placeholder' => 'Id',
                'class' => 'form-control'
            ]);
        }

        $this->add($id);


        $this->add(new Text('shortDescription', [
            'placeholder' => 'short description -> if you want to tell something',
            'class' => 'form-control'
        ]));

        $this->add(new TextArea('longDescription', [
            'placeholder' => 'short description -> if you want to tell more ;) ',
            'class' => 'form-control'
        ]));

        if (is_null($operationShift)) {
            // make selectable from operationShiftID, same as set
            $params = (is_null($entity) ? [] : ['operationShiftId'=>$operationShift->getId()] );
            $opShiftDepartmentSelect = OperationshiftsDepartmentsLink::find($params);
            $canUseEmpty = ($currentAction == 'index');
            $this->add(new Select('opDepNeedId', $opShiftDepartmentSelect, [
                'using'      => [
                    'id',
                    'label',
                ],
                'useEmpty'   => $canUseEmpty,
                'emptyText'  => 'any department',
                'emptyValue' => '',
                'class' => 'form-control  mr-sm-3'
            ]));
            $this->add(new Hidden('opDepNeedIdDisabled'));
        } else { // one fix entry
            $value = $operationShiftDepartmentNeeds->getId();
            $label = $operationShiftDepartmentNeeds->getLabel();

            $options = [$value => $label];
            $attributes = [
                'class' => 'form-control',
                'disabled' => 'true'
            ];
            $opDepNeedId = new Hidden('opDepNeedId');
            $opDepNeedId->setAttribute('value', $value);
            $this->add($opDepNeedId);
            $s = new Select('opDepNeedIdDisabled', $options, $attributes);
            $s->setDefault($value);
            $this->add($s);
        }


        if (is_null($volunteer)) {
            // only volunteers that do not exists
            $params = []; // todo: select only volunteers that have not committed yet
            $volunteers = Volunteers::find($params);
            $canUseEmpty = ($currentAction == 'index');
            $this->add(new Select('volunteersId', $volunteers, [
                'using'      => [
                    'id',
                    'firstAndLastName',
                ],
                'useEmpty'   => $canUseEmpty,
                'emptyText'  => 'any department',
                'emptyValue' => '',
                'class' => 'form-control  mr-sm-3'
            ]));
            $this->add(new Hidden('volunteersIdDisabled'));
        } else { // one fix entry
            /**
             * @var Volunteers $v
             */
            $value = $volunteer->getId();
            $label = $volunteer->getFirstAndLastName();

            $options = [$value => $label];
            $attributes = [
                'class' => 'form-control',
                'disabled' => 'true'
            ];
            $volunteersId = new Hidden('volunteersId');
            $volunteersId->setAttribute('value', $value);
            $this->add($volunteersId);
            $s = new Select('volunteersIdDisabled', $options, $attributes);
            $s->setDefault($value);
            $this->add($s);
        }

        $certificates = [];
        if (is_null($volunteer)) {
            $certificates = Certificates::find();
        } else {
            $modelManager = $this
                ->modelsManager
                ->createBuilder()
                //->columns(['"[Certificates].[id]','[Certificates].[label]'])
                ->from(Certificates::class)
                ->join(VolunteersCertificatesLink::class, 'volunteersId = '.$volunteer->getId())
                ->getQuery()
                ->execute();
                //->getSingleResult(['operation_id' =>  $this->getOperationId()]);

            foreach ($modelManager as $c) {
                $certificates = array_merge($certificates, [$c->getId() => $c->getLabel()]);
            }
        }

        $this->add(new Select('volCurrentMaximumCertRank', $certificates, [
            'using'      => [
                'id',
                'label',
            ],
            'useEmpty'   => true,
            'emptyText'  => 'any',
            'emptyValue' => '',
            'class' => 'form-control  mr-sm-3'
        ]));
    }
}
