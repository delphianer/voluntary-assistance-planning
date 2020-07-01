<?php

namespace Vokuro\Models;

class Equipment extends \Phalcon\Mvc\Model
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
    protected $desc_short;

    /**
     *
     * @var string
     */
    protected $desc_long;

    /**
     *
     * @var integer
     */
    protected $total_count;

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
     * Method to set the value of field total_count
     *
     * @param integer $total_count
     * @return $this
     */
    public function setTotalCount($total_count)
    {
        $this->total_count = $total_count;

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
     * Returns the value of field total_count
     *
     * @return integer
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("equipment");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipment[]|Equipment|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipment|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}