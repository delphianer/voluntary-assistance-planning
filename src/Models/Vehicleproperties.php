<?php

namespace Vokuro\Models;

class Vehicleproperties extends \Phalcon\Mvc\Model
{

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
    protected $desc_short;

    /**
     *
     * @var string
     */
    protected $desc_long;

    /**
     *
     * @var string
     */
    protected $is_numeric;

    /**
     *
     * @var string
     */
    protected $value_string;

    /**
     *
     * @var double
     */
    protected $value_numeric;

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $vehiclesId;

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
    protected $desc_short;

    /**
     *
     * @var string
     */
    protected $desc_long;

    /**
     *
     * @var string
     */
    protected $is_numeric;

    /**
     *
     * @var string
     */
    protected $value_string;

    /**
     *
     * @var double
     */
    protected $value_numeric;

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
     * Method to set the value of field vehiclesId
     *
     * @param integer $vehiclesId
     * @return $this
     */
    public function setVehiclesId($vehiclesId)
    {
        $this->vehiclesId = $vehiclesId;

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
     * Method to set the value of field desc_short
     *
     * @param string $desc_short
     * @return $this
     */
    public function setDescShort($desc_short)
    {
        $this->desc_short = $desc_short;

        return $this;
    }

    /**
     * Method to set the value of field desc_long
     *
     * @param string $desc_long
     * @return $this
     */
    public function setDescLong($desc_long)
    {
        $this->desc_long = $desc_long;

        return $this;
    }

    /**
     * Method to set the value of field is_numeric
     *
     * @param string $is_numeric
     * @return $this
     */
    public function setIsNumeric($is_numeric)
    {
        $this->is_numeric = $is_numeric;

        return $this;
    }

    /**
     * Method to set the value of field value_string
     *
     * @param string $value_string
     * @return $this
     */
    public function setValueString($value_string)
    {
        $this->value_string = $value_string;

        return $this;
    }

    /**
     * Method to set the value of field value_numeric
     *
     * @param double $value_numeric
     * @return $this
     */
    public function setValueNumeric($value_numeric)
    {
        $this->value_numeric = $value_numeric;

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
     * Returns the value of field vehiclesId
     *
     * @return integer
     */
    public function getVehiclesId()
    {
        return $this->vehiclesId;
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
     * Returns the value of field desc_short
     *
     * @return string
     */
    public function getDescShort()
    {
        return $this->desc_short;
    }

    /**
     * Returns the value of field desc_long
     *
     * @return string
     */
    public function getDescLong()
    {
        return $this->desc_long;
    }

    /**
     * Returns the value of field is_numeric
     *
     * @return string
     */
    public function getIsNumeric()
    {
        return $this->is_numeric;
    }

    /**
     * Returns the value of field value_string
     *
     * @return string
     */
    public function getValueString()
    {
        return $this->value_string;
    }

    /**
     * Returns the value of field value_numeric
     *
     * @return double
     */
    public function getValueNumeric()
    {
        return $this->value_numeric;
    }

    /**
     * Method to set the value of field vehiclesId
     *
     * @param integer $vehiclesId
     * @return $this
     */
    public function setVehiclesId($vehiclesId)
    {
        $this->vehiclesId = $vehiclesId;

        return $this;
    }

    /**
     * Returns the value of field vehiclesId
     *
     * @return integer
     */
    public function getVehiclesId()
    {
        return $this->vehiclesId;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("vehicleproperties");
        $this->belongsTo('vehiclesId', 'Vokuro\Models\Vehicles', 'id', ['alias' => 'Vehicles']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vehicleproperties[]|Vehicleproperties|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Vehicleproperties|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
