<?php

namespace Vokuro\Models;

class Vehicles extends \Phalcon\Mvc\Model
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
     * @var string
     */
    protected $update_time;

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
    protected $technicalInspection;

    /**
     *
     * @var integer
     */
    protected $seatCount;

    /**
     *
     * @var string
     */
    protected $isAmbulance;

    /**
     *
     * @var string
     */
    protected $hasFlashingLights;

    /**
     *
     * @var string
     */
    protected $hasRadioCom;

    /**
     *
     * @var string
     */
    protected $hasDigitalRadioCom;

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
     * Method to set the value of field technicalInspection
     *
     * @param string $technicalInspection
     * @return $this
     */
    public function setTechnicalInspection($technicalInspection)
    {
        $this->technicalInspection = $technicalInspection;

        return $this;
    }

    /**
     * Method to set the value of field seatCount
     *
     * @param integer $seatCount
     * @return $this
     */
    public function setSeatCount($seatCount)
    {
        $this->seatCount = $seatCount;

        return $this;
    }

    /**
     * Method to set the value of field isAmbulance
     *
     * @param string $isAmbulance
     * @return $this
     */
    public function setIsAmbulance($isAmbulance)
    {
        $this->isAmbulance = $isAmbulance;

        return $this;
    }

    /**
     * Method to set the value of field hasFlashingLights
     *
     * @param string $hasFlashingLights
     * @return $this
     */
    public function setHasFlashingLights($hasFlashingLights)
    {
        $this->hasFlashingLights = $hasFlashingLights;

        return $this;
    }

    /**
     * Method to set the value of field hasRadioCom
     *
     * @param string $hasRadioCom
     * @return $this
     */
    public function setHasRadioCom($hasRadioCom)
    {
        $this->hasRadioCom = $hasRadioCom;

        return $this;
    }

    /**
     * Method to set the value of field hasDigitalRadioCom
     *
     * @param string $hasDigitalRadioCom
     * @return $this
     */
    public function setHasDigitalRadioCom($hasDigitalRadioCom)
    {
        $this->hasDigitalRadioCom = $hasDigitalRadioCom;

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
     * Returns the value of field update_time
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->update_time;
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
     * Returns the value of field technicalInspection
     *
     * @return string
     */
    public function getTechnicalInspection()
    {
        return $this->technicalInspection;
    }

    /**
     * Returns the value of field seatCount
     *
     * @return integer
     */
    public function getSeatCount()
    {
        return $this->seatCount;
    }

    /**
     * Returns the value of field isAmbulance
     *
     * @return string
     */
    public function getIsAmbulance()
    {
        return $this->isAmbulance;
    }

    /**
     * Returns the value of field hasFlashingLights
     *
     * @return string
     */
    public function getHasFlashingLights()
    {
        return $this->hasFlashingLights;
    }

    /**
     * Returns the value of field hasRadioCom
     *
     * @return string
     */
    public function getHasRadioCom()
    {
        return $this->hasRadioCom;
    }

    /**
     * Returns the value of field hasDigitalRadioCom
     *
     * @return string
     */
    public function getHasDigitalRadioCom()
    {
        return $this->hasDigitalRadioCom;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("vehicles");
        $this->hasMany('id', 'Vokuro\Models\OperationshiftsVehiclesLink', 'vehicleId', ['alias' => 'OperationshiftsVehiclesLink']);
        $this->hasMany('id', 'Vokuro\Models\Vehicleproperties', 'vehiclesId', ['alias' => 'Vehicleproperties']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vehicles[]|Vehicles|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vehicles|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
