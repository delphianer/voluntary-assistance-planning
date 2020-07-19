<?php

namespace Vokuro\Models;

class OperationshiftsDepartmentsLink extends \Phalcon\Mvc\Model
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
    protected $departmentId;

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
    protected $numberVolunteersNeeded;

    /**
     *
     * @var integer
     */
    protected $minimumCertificateRanking;

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
     * Method to set the value of field departmentId
     *
     * @param integer $departmentId
     * @return $this
     */
    public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;

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
     * Method to set the value of field numberVolunteersNeeded
     *
     * @param integer $numberVolunteersNeeded
     * @return $this
     */
    public function setNumberVolunteersNeeded($numberVolunteersNeeded)
    {
        $this->numberVolunteersNeeded = $numberVolunteersNeeded;

        return $this;
    }

    /**
     * Method to set the value of field minimumCertificateRanking
     *
     * @param integer $minimumCertificateRanking
     * @return $this
     */
    public function setMinimumCertificateRanking($minimumCertificateRanking)
    {
        $this->minimumCertificateRanking = $minimumCertificateRanking;

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
     * Returns the value of field departmentId
     *
     * @return integer
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
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
     * Returns the value of field numberVolunteersNeeded
     *
     * @return integer
     */
    public function getNumberVolunteersNeeded()
    {
        return $this->numberVolunteersNeeded;
    }

    /**
     * Returns the value of field minimumCertificateRanking
     *
     * @return integer
     */
    public function getMinimumCertificateRanking()
    {
        return $this->minimumCertificateRanking;
    }

    /**
     * Returns the value of no field minimumCertificateRanking
     *
     * @return string
     */
    public function getMinimumCertificateRankingLabel()
    {
        $cert = Certificates::findFirstByid($this->minimumCertificateRanking);
        if (isset($cert)) {
            return $cert->getLabel();
        } else {
            return '-';
        }
    }



    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("operationshifts_departments_link");
        $this->hasMany('id', 'Vokuro\Models\OpshdeplVolunteersLink', 'opDepNeedId', ['alias' => 'OpshdeplVolunteersLink']);
        $this->belongsTo('departmentId', 'Vokuro\Models\Departments', 'id', ['alias' => 'Departments']);
        $this->belongsTo('operationShiftId', 'Vokuro\Models\Operationshifts', 'id', ['alias' => 'Operationshifts']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return OperationshiftsDepartmentsLink[]|OperationshiftsDepartmentsLink|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return OperationshiftsDepartmentsLink|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
}
