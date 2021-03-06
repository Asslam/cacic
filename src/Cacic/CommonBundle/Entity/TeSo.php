<?php

namespace Cacic\CommonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Created by PhpStorm.
 * User: Bruno Noronha
 * Date: 17/03/15
 * Time: 14:42
 */
class TeSo
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $idSo;

    /**
     * @var string
     */
    private $teSo28;

    /**
     * @var string
     */
    private $teSo31;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idSo
     *
     * @param string $idSo
     * @return TeSo
     */
    public function setIdSo($idSo)
    {
        $this->idSo = $idSo;

        return $this;
    }

    /**
     * Get idSo
     *
     * @return integer
     */
    public function getIdSo()
    {
        return $this->idSo;
    }

    /**
     * Set teSo28
     *
     * @param string $teSo28
     * @return TeSo
     */
    public function setTeSo28($teSo28)
    {
        $this->teSo28 = $teSo28;

        return $this;
    }

    /**
     * Get teSo28
     *
     * @return string
     */
    public function getTeSo28()
    {
        return $this->teSo28;
    }

    /**
     * Set teSo31
     *
     * @param string $teSo31
     * @return TeSo
     */
    public function setTeSo31($teSo31)
    {
        $this->teSo31 = $teSo31;

        return $this;
    }

    /**
     * Get teSo31
     *
     * @return string
     */
    public function getTeSo31()
    {
        return $this->teSo31;
    }

}
