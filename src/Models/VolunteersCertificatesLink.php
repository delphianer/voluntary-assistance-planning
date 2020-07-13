<?php

namespace Vokuro\Models;

class VolunteersCertificatesLink extends \Phalcon\Mvc\Model
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
     * @var integer
     */
    protected $volunteersId;

    /**
     *
     * @var integer
     */
    protected $certificatesId;

    /**
     *
     * @var string
     */
    protected $validUntil;

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
     * Method to set the value of field certificatesId
     *
     * @param integer $certificatesId
     * @return $this
     */
    public function setCertificatesId($certificatesId)
    {
        $this->certificatesId = $certificatesId;

        return $this;
    }

    /**
     * Method to set the value of field validUntil
     *
     * @param string $validUntil
     * @return $this
     */
    public function setValidUntil($validUntil)
    {
        $this->validUntil = $validUntil;

        return $this;
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
     * Returns the value of field volunteersId
     *
     * @return integer
     */
    public function getVolunteersId()
    {
        return $this->volunteersId;
    }

    /**
     * Returns the value of field certificatesId
     *
     * @return integer
     */
    public function getCertificatesId()
    {
        return $this->certificatesId;
    }

    /**
     * Returns the value of field validUntil
     *
     * @return string
     */
    public function getValidUntil()
    {
        return $this->validUntil;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("vokuro");
        $this->setSource("volunteers_certificates_link");
        $this->belongsTo('certificatesId', 'Vokuro\Models\Certificates', 'id', ['alias' => 'Certificates']);
        $this->belongsTo('volunteersId', 'Vokuro\Models\Volunteers', 'id', ['alias' => 'Volunteers']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return VolunteersCertificatesLink[]|VolunteersCertificatesLink|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return VolunteersCertificatesLink|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
