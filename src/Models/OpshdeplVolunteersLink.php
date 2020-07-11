<?php

namespace Vokuro\Models;

class OpshdeplVolunteersLink extends \Phalcon\Mvc\Model
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
    protected $shortDescription;

    /**
     *
     * @var string
     */
    protected $longDescription;

    /**
     *
     * @var integer
     */
    protected $opDepNeedId;

    /**
     *
     * @var integer
     */
    protected $volunteersId;

    /**
     *
     * @var integer
     */
    protected $volCurrentMaximumCertRank;

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
     * Method to set the value of field opDepNeedId
     *
     * @param integer $opDepNeedId
     * @return $this
     */
    public function setOpDepNeedId($opDepNeedId)
    {
        $this->opDepNeedId = $opDepNeedId;

        return $this;
    }

    /**
     * Method to set the value of field volunteersId
     *
     * @param integer $volunteersId
     * @return $this
     */
    public function setVolunteersId($volunteersId)
    {
        $this->volunteersId = $volunteersId;

        return $this;
    }

    /**
     * Method to set the value of field volCurrentMaximumCertRank
     *
     * @param integer $volCurrentMaximumCertRank
     * @return $this
     */
    public function setVolCurrentMaximumCertRank($volCurrentMaximumCertRank)
    {
        $this->volCurrentMaximumCertRank = $volCurrentMaximumCertRank;

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
     * Returns the value of field opDepNeedId
     *
     * @return integer
     */
    public function getOpDepNeedId()
    {
        return $this->opDepNeedId;
    }

    /**
     * Returns the value of field volunteersId
     *
     * @return integer
     */
    public function getVolunteersId()
    {
        return $this->volunteersId;
    }

    /**
     * Returns the value of field volCurrentMaximumCertRank
     *
     * @return integer
     */
    public function getVolCurrentMaximumCertRank()
    {
        return $this->volCurrentMaximumCertRank;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("opshdepl_volunteers_link");
        $this->belongsTo('opDepNeedId', 'Vokuro\Models\OperationshiftsDepartmentsLink', 'id', ['alias' => 'OperationshiftsDepartmentsLink']);
        $this->belongsTo('volunteersId', 'Vokuro\Models\Volunteers', 'id', ['alias' => 'Volunteers']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OpshdeplVolunteersLink[]|OpshdeplVolunteersLink|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OpshdeplVolunteersLink|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
