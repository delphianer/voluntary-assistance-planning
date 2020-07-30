<?php

namespace Vokuro\Models;

class Appointments extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

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
    protected $label;

    /**
     *
     * @var string
     */
    protected $description;

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
     *
     * @var integer
     */
    protected $locationId;

    /**
     *
     * @var integer
     */
    protected $mainDepartmentId;

    /**
     *
     * @var integer
     */
    protected $clientId;

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
     * Method to set the value of field label
     *
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Method to set the value of field description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Method to set the value of field mainDepartmentId
     *
     * @param integer $mainDepartmentId
     * @return $this
     */
    public function setMainDepartmentId($mainDepartmentId)
    {
        $this->mainDepartmentId = $mainDepartmentId;

        return $this;
    }

    /**
     * Method to set the value of field clientId
     *
     * @param integer $clientId
     * @return $this
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

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
     * Returns the value of field label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the value of field description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * Returns the value of field locationId
     *
     * @return integer
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * Returns the value of field mainDepartmentId
     *
     * @return integer
     */
    public function getMainDepartmentId()
    {
        return $this->mainDepartmentId;
    }

    /**
     * Returns the value of field clientId
     *
     * @return integer
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("appointments");
        $this->belongsTo(
            'clientId',
            'Vokuro\Models\Clients',
            'id',
            ['alias' => 'Clients']
        );
        $this->belongsTo(
            'mainDepartmentId',
            'Vokuro\Models\Departments',
            'id',
            ['alias' => 'Departments']
        );
        $this->belongsTo('locationId',
            'Vokuro\Models\Locations',
            'id',
            ['alias' => 'Locations']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appointments[]|Appointments|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Appointments|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
