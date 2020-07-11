<?php

namespace Vokuro\Models;

class OperationshiftsEquipmentLink extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $operationShiftId;

    /**
     *
     * @var integer
     */
    protected $equipmentId;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     *
     * @var string
     */
    protected $update_time;

    /**
     *
     * @var string
     */
    protected $shortDescription;

    /**
     *
     * @var string
     */
    protected $longDescription;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field operationShiftId
     *
     * @param integer $operationShiftId
     * @return $this
     */
    public function setOperationShiftId($operationShiftId)
    {
        $this->operationShiftId = $operationShiftId;

        return $this;
    }

    /**
     * Method to set the value of field equipmentId
     *
     * @param integer $equipmentId
     * @return $this
     */
    public function setEquipmentId($equipmentId)
    {
        $this->equipmentId = $equipmentId;

        return $this;
    }

    /**
     * Method to set the value of field create_time
     *
     * @param string $create_time
     * @return $this
     */
    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;

        return $this;
    }

    /**
     * Method to set the value of field update_time
     *
     * @param string $update_time
     * @return $this
     */
    public function setUpdateTime($update_time)
    {
        $this->update_time = $update_time;

        return $this;
    }

    /**
     * Method to set the value of field shortDescription
     *
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * Method to set the value of field longDescription
     *
     * @param string $longDescription
     * @return $this
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription = $longDescription;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field operationShiftId
     *
     * @return integer
     */
    public function getOperationShiftId()
    {
        return $this->operationShiftId;
    }

    /**
     * Returns the value of field equipmentId
     *
     * @return integer
     */
    public function getEquipmentId()
    {
        return $this->equipmentId;
    }

    /**
     * Returns the value of field create_time
     *
     * @return string
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * Returns the value of field update_time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    /**
     * Returns the value of field shortDescription
     *
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Returns the value of field longDescription
     *
     * @return string
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("operationshifts_equipment_link");
        $this->belongsTo('equipmentId', 'Vokuro\Models\Equipment', 'id', ['alias' => 'Equipment']);
        $this->belongsTo('operationShiftId', 'Vokuro\Models\Operationshifts', 'id', ['alias' => 'Operationshifts']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OperationshiftsEquipmentLink[]|OperationshiftsEquipmentLink|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OperationshiftsEquipmentLink|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
