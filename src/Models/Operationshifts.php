<?php

namespace Vokuro\Models;

class Operationshifts extends \Phalcon\Mvc\Model
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
    protected $operationId;

    /**
     *
     * @var integer
     */
    protected $locationId;

    /**
     *
     * @var string
     */
    protected $create_time;

    /**
     *
     * @var integer
     */
    protected $create_userId;

    /**
     *
     * @var string
     */
    protected $update_time;

    /**
     *
     * @var integer
     */
    protected $update_userId;

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
     *
     * @var string
     */
    protected $start;

    /**
     *
     * @var string
     */
    protected $end;

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
     * Method to set the value of field operationId
     *
     * @param integer $operationId
     * @return $this
     */
    public function setOperationId($operationId)
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * Method to set the value of field locationId
     *
     * @param integer $locationId
     * @return $this
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;

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
     * Method to set the value of field create_userId
     *
     * @param integer $create_userId
     * @return $this
     */
    public function setCreateUserId($create_userId)
    {
        $this->create_userId = $create_userId;

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
     * Method to set the value of field update_userId
     *
     * @param integer $update_userId
     * @return $this
     */
    public function setUpdateUserId($update_userId)
    {
        $this->update_userId = $update_userId;

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
     * Method to set the value of field start
     *
     * @param string $start
     * @return $this
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Method to set the value of field end
     *
     * @param string $end
     * @return $this
     */
    public function setEnd($end)
    {
        $this->end = $end;

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
     * Returns the value of field operationId
     *
     * @return integer
     */
    public function getOperationId()
    {
        return $this->operationId;
    }

    /**
     * Returns the value of field locationId
     *
     * @return integer
     */
    public function getLocationId()
    {
        return $this->locationId;
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
     * Returns the value of field create_userId
     *
     * @return integer
     */
    public function getCreateUserId()
    {
        return $this->create_userId;
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
     * Returns the value of field update_userId
     *
     * @return integer
     */
    public function getUpdateUserId()
    {
        return $this->update_userId;
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
     * Returns the value of field start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Returns the value of field end
     *
     * @return string
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("operationshifts");
        $this->hasMany('id', 'Vokuro\Models\OperationshiftsDepartmentsLink', 'operationShiftId', ['alias' => 'OperationshiftsDepartmentsLink']);
        $this->hasMany('id', 'Vokuro\Models\OperationshiftsEquipmentLink', 'operationShiftId', ['alias' => 'OperationshiftsEquipmentLink']);
        $this->hasMany('id', 'Vokuro\Models\OperationshiftsVehiclesLink', 'operationShiftId', ['alias' => 'OperationshiftsVehiclesLink']);
        $this->belongsTo('locationId', 'Vokuro\Models\Locations', 'id', ['alias' => 'Locations']);
        $this->belongsTo('operationId', 'Vokuro\Models\Operations', 'id', ['alias' => 'Operations']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Operationshifts[]|Operationshifts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Operationshifts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
