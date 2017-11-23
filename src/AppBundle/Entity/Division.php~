<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Division
 *
 * @ORM\Table(name="division")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DivisionRepository")
 */
class Division
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviatura", type="string", length=45, nullable=false)
     */
    private $abreviatura;

    /**
     * @var string
     *
     * @ORM\Column(name="dGrado", type="string", length=10, nullable=true)
     */
    private $dGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="dNombre", type="string", length=45, nullable=false)
     */
    private $dNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dApellido_paterno", type="string", length=45, nullable=false)
     */
    private $dApellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="dApellido_materno", type="string", length=45, nullable=true)
     */
    private $dApellidoMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="saGrado", type="string", length=10, nullable=true)
     */
    private $saGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="saNombre", type="string", length=45, nullable=false)
     */
    private $saNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="saApellido_paterno", type="string", length=45, nullable=false)
     */
    private $saApellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="saApellido_materno", type="string", length=45, nullable=true)
     */
    private $saApellidoMaterno;



    /**
     * AQUI ESTOY GENERANDO LAS FUNCIONES PUBLICAS
     */

    public function __toString()
    {
        return $this->abreviatura;
    }


    /**
     * Set id
     *
     * @param integer $id
     *
     */
    public function setId($id)
    {
        $this->id = $id;
    }


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Division
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set abreviatura
     *
     * @param string $abreviatura
     *
     * @return Division
     */
    public function setAbreviatura($abreviatura)
    {
        $this->abreviatura = $abreviatura;

        return $this;
    }

    /**
     * Get abreviatura
     *
     * @return string
     */
    public function getAbreviatura()
    {
        return $this->abreviatura;
    }

    /**
     * Set dGrado
     *
     * @param string $dGrado
     *
     * @return Division
     */
    public function setDGrado($dGrado)
    {
        $this->dGrado = $dGrado;

        return $this;
    }

    /**
     * Get dGrado
     *
     * @return string
     */
    public function getDGrado()
    {
        return $this->dGrado;
    }

    /**
     * Set dNombre
     *
     * @param string $dNombre
     *
     * @return Division
     */
    public function setDNombre($dNombre)
    {
        $this->dNombre = $dNombre;

        return $this;
    }

    /**
     * Get dNombre
     *
     * @return string
     */
    public function getDNombre()
    {
        return $this->dNombre;
    }

    /**
     * @return string
     */
    public function getDNombreCompleto()
    {
        return $this->dGrado." ".$this->dNombre." ".$this->dApellidoPaterno." ".$this->dApellidoMaterno;
    }

    /**
     * Set dApellidoPaterno
     *
     * @param string $dApellidoPaterno
     *
     * @return Division
     */
    public function setDApellidoPaterno($dApellidoPaterno)
    {
        $this->dApellidoPaterno = $dApellidoPaterno;

        return $this;
    }

    /**
     * Get dApellidoPaterno
     *
     * @return string
     */
    public function getDApellidoPaterno()
    {
        return $this->dApellidoPaterno;
    }

    /**
     * Set dApellidoMaterno
     *
     * @param string $dApellidoMaterno
     *
     * @return Division
     */
    public function setDApellidoMaterno($dApellidoMaterno)
    {
        $this->dApellidoMaterno = $dApellidoMaterno;

        return $this;
    }

    /**
     * Get dApellidoMaterno
     *
     * @return string
     */
    public function getDApellidoMaterno()
    {
        return $this->dApellidoMaterno;
    }

    /**
     * Set saGrado
     *
     * @param string $saGrado
     *
     * @return Division
     */
    public function setSaGrado($saGrado)
    {
        $this->saGrado = $saGrado;

        return $this;
    }

    /**
     * Get saGrado
     *
     * @return string
     */
    public function getSaGrado()
    {
        return $this->saGrado;
    }

    /**
     * Set saNombre
     *
     * @param string $saNombre
     *
     * @return Division
     */
    public function setSaNombre($saNombre)
    {
        $this->saNombre = $saNombre;

        return $this;
    }

    /**
     * Get saNombre
     *
     * @return string
     */
    public function getSaNombre()
    {
        return $this->saNombre;
    }

    /**
     * @return string
     */
    public function getSaNombreCompleto()
    {
        return $this->saGrado." ".$this->saNombre." ".$this->saApellidoPaterno." ".$this->saApellidoMaterno;

    }


    /**
     * Set saApellidoPaterno
     *
     * @param string $saApellidoPaterno
     *
     * @return Division
     */
    public function setSaApellidoPaterno($saApellidoPaterno)
    {
        $this->saApellidoPaterno = $saApellidoPaterno;

        return $this;
    }

    /**
     * Get saApellidoPaterno
     *
     * @return string
     */
    public function getSaApellidoPaterno()
    {
        return $this->saApellidoPaterno;
    }

    /**
     * Set saApellidoMaterno
     *
     * @param string $saApellidoMaterno
     *
     * @return Division
     */
    public function setSaApellidoMaterno($saApellidoMaterno)
    {
        $this->saApellidoMaterno = $saApellidoMaterno;

        return $this;
    }

    /**
     * Get saApellidoMaterno
     *
     * @return string
     */
    public function getSaApellidoMaterno()
    {
        return $this->saApellidoMaterno;
    }
}
