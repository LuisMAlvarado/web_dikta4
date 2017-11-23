<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departamento
 *
 * @ORM\Table(name="prefulldictamen", indexes={@ORM\Index(name="fk_PrefullDictamen_Division1_idx", columns={"Division_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrefullDictamenRepository")
 */
class PrefullDictamen
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var \Division
     *
     * @ORM\ManyToOne(targetEntity="Division")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Division_id", referencedColumnName="id")
     * })
     */
    private $division;

    /**
     * @var string
     *
     * @ORM\Column(name="evaluaciones", type="text", nullable=true)
     */
    private $evaluaciones;

    /**
     * @var string
     *
     * @ORM\Column(name="argumento", type="text", nullable=true)
     */
    private $argumento;

    /**
     * @var string
     *
     * @ORM\Column(name="dicpresGrado", type="string", length=10, nullable=true)
     */
    private $dicpresGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="dicpresNombre", type="string", length=45, nullable=true)
     */
    private $dicpresNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dicpresApellido_paterno", type="string", length=45, nullable=true)
     */
    private $dicpresApellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="dicpresApellido_materno", type="string", length=45, nullable=true)
     */
    private $dicpresApellidoMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="dicsecGrado", type="string", length=10, nullable=true)
     */
    private $dicsecGrado;

    /**
     * @var string
     *
     * @ORM\Column(name="dicsecNombre", type="string", length=45, nullable=true)
     */
    private $dicsecNombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dicsecApellido_paterno", type="string", length=45, nullable=true)
     */
    private $dicsecApellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="dicsecApellido_materno", type="string", length=45, nullable=true)
     */
    private $dicsecApellidoMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor1", type="text", nullable=true)
     */
    private $asesor1;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor2", type="text", nullable=true)
     */
    private $asesor2;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor3", type="text", nullable=true)
     */
    private $asesor3;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor4", type="text", nullable=true)
     */
    private $asesor4;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor5", type="text", nullable=true)
     */
    private $asesor5;

    /**
     * @var string
     *
     * @ORM\Column(name="asesor6", type="text", nullable=true)
     */
    private $asesor6;


    /**
     * AQUI ESTOY GENERANDO LAS FUNCIONES PUBLICAS
     */



    /**
     * Constructor
     */
    public function __construct()
    {

    }



    /**
     * Set id
     *
     * @param integer $id
     *
     * @return PrefullDictamen
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set evaluaciones
     *
     * @param string $evaluaciones
     *
     * @return PrefullDictamen
     */
    public function setEvaluaciones($evaluaciones)
    {
        $this->evaluaciones = $evaluaciones;

        return $this;
    }

    /**
     * Get evaluaciones
     *
     * @return string
     */
    public function getEvaluaciones()
    {
        return $this->evaluaciones;
    }

    /**
     * Set argumento
     *
     * @param string $argumento
     *
     * @return PrefullDictamen
     */
    public function setArgumento($argumento)
    {
        $this->argumento = $argumento;

        return $this;
    }

    /**
     * Get argumento
     *
     * @return string
     */
    public function getArgumento()
    {
        return $this->argumento;
    }

    /**
     * Set dicpresGrado
     *
     * @param string $dicpresGrado
     *
     * @return PrefullDictamen
     */
    public function setDicpresGrado($dicpresGrado)
    {
        $this->dicpresGrado = $dicpresGrado;

        return $this;
    }

    /**
     * Get dicpresGrado
     *
     * @return string
     */
    public function getDicpresGrado()
    {
        return $this->dicpresGrado;
    }

    /**
     * Set dicpresNombre
     *
     * @param string $dicpresNombre
     *
     * @return PrefullDictamen
     */
    public function setDicpresNombre($dicpresNombre)
    {
        $this->dicpresNombre = $dicpresNombre;

        return $this;
    }

    /**
     * Get dicpresNombre
     *
     * @return string
     */
    public function getDicpresNombre()
    {
        return $this->dicpresNombre;
    }

    /**
     * Set dicpresApellidoPaterno
     *
     * @param string $dicpresApellidoPaterno
     *
     * @return PrefullDictamen
     */
    public function setDicpresApellidoPaterno($dicpresApellidoPaterno)
    {
        $this->dicpresApellidoPaterno = $dicpresApellidoPaterno;

        return $this;
    }

    /**
     * Get dicpresApellidoPaterno
     *
     * @return string
     */
    public function getDicpresApellidoPaterno()
    {
        return $this->dicpresApellidoPaterno;
    }

    /**
     * Set dicpresApellidoMaterno
     *
     * @param string $dicpresApellidoMaterno
     *
     * @return PrefullDictamen
     */
    public function setDicpresApellidoMaterno($dicpresApellidoMaterno)
    {
        $this->dicpresApellidoMaterno = $dicpresApellidoMaterno;

        return $this;
    }

    /**
     * Get dicpresApellidoMaterno
     *
     * @return string
     */
    public function getDicpresApellidoMaterno()
    {
        return $this->dicpresApellidoMaterno;
    }


    //NOMBRE COMPLETO DEL PRESIDENTE DICTAMINADOR
    public function getNombreCompletoPres()
    {
        return $this->dicpresGrado." ".$this->dicpresNombre." ".$this->dicpresApellidoPaterno." ".$this->dicpresApellidoMaterno;
    }

    //NOMBRE COMPLETO DEL SECRETARIO DICTAMINADOR
    public function getNombreCompletoSec()
    {
        return $this->dicsecGrado." ".$this->dicsecNombre." ".$this->dicsecApellidoPaterno." ".$this->dicsecApellidoMaterno;
    }

    /**
     * Set dicsecGrado
     *
     * @param string $dicsecGrado
     *
     * @return PrefullDictamen
     */
    public function setDicsecGrado($dicsecGrado)
    {
        $this->dicsecGrado = $dicsecGrado;

        return $this;
    }

    /**
     * Get dicsecGrado
     *
     * @return string
     */
    public function getDicsecGrado()
    {
        return $this->dicsecGrado;
    }

    /**
     * Set dicsecNombre
     *
     * @param string $dicsecNombre
     *
     * @return PrefullDictamen
     */
    public function setDicsecNombre($dicsecNombre)
    {
        $this->dicsecNombre = $dicsecNombre;

        return $this;
    }

    /**
     * Get dicsecNombre
     *
     * @return string
     */
    public function getDicsecNombre()
    {
        return $this->dicsecNombre;
    }

    /**
     * Set dicsecApellidoPaterno
     *
     * @param string $dicsecApellidoPaterno
     *
     * @return PrefullDictamen
     */
    public function setDicsecApellidoPaterno($dicsecApellidoPaterno)
    {
        $this->dicsecApellidoPaterno = $dicsecApellidoPaterno;

        return $this;
    }

    /**
     * Get dicsecApellidoPaterno
     *
     * @return string
     */
    public function getDicsecApellidoPaterno()
    {
        return $this->dicsecApellidoPaterno;
    }

    /**
     * Set dicsecApellidoMaterno
     *
     * @param string $dicsecApellidoMaterno
     *
     * @return PrefullDictamen
     */
    public function setDicsecApellidoMaterno($dicsecApellidoMaterno)
    {
        $this->dicsecApellidoMaterno = $dicsecApellidoMaterno;

        return $this;
    }

    /**
     * Get dicsecApellidoMaterno
     *
     * @return string
     */
    public function getDicsecApellidoMaterno()
    {
        return $this->dicsecApellidoMaterno;
    }

    /**
     * Set asesor1
     *
     * @param string $asesor1
     *
     * @return PrefullDictamen
     */
    public function setAsesor1($asesor1)
    {
        $this->asesor1 = $asesor1;

        return $this;
    }

    /**
     * Get asesor1
     *
     * @return string
     */
    public function getAsesor1()
    {
        return $this->asesor1;
    }

    /**
     * Set asesor2
     *
     * @param string $asesor2
     *
     * @return PrefullDictamen
     */
    public function setAsesor2($asesor2)
    {
        $this->asesor2 = $asesor2;

        return $this;
    }

    /**
     * Get asesor2
     *
     * @return string
     */
    public function getAsesor2()
    {
        return $this->asesor2;
    }

    /**
     * Set asesor3
     *
     * @param string $asesor3
     *
     * @return PrefullDictamen
     */
    public function setAsesor3($asesor3)
    {
        $this->asesor3 = $asesor3;

        return $this;
    }

    /**
     * Get asesor3
     *
     * @return string
     */
    public function getAsesor3()
    {
        return $this->asesor3;
    }

    /**
     * Set asesor4
     *
     * @param string $asesor4
     *
     * @return PrefullDictamen
     */
    public function setAsesor4($asesor4)
    {
        $this->asesor4 = $asesor4;

        return $this;
    }

    /**
     * Get asesor4
     *
     * @return string
     */
    public function getAsesor4()
    {
        return $this->asesor4;
    }

    /**
     * Set asesor5
     *
     * @param string $asesor5
     *
     * @return PrefullDictamen
     */
    public function setAsesor5($asesor5)
    {
        $this->asesor5 = $asesor5;

        return $this;
    }

    /**
     * Get asesor5
     *
     * @return string
     */
    public function getAsesor5()
    {
        return $this->asesor5;
    }

    /**
     * Set asesor6
     *
     * @param string $asesor6
     *
     * @return PrefullDictamen
     */
    public function setAsesor6($asesor6)
    {
        $this->asesor6 = $asesor6;

        return $this;
    }

    /**
     * Get asesor6
     *
     * @return string
     */
    public function getAsesor6()
    {
        return $this->asesor6;
    }

    //NOMBRE COMPLETO DEL SECRETARIO DICTAMINADOR
    public function getAsores1_4()
    {
        return $this->asesor1." ".$this->asesor4;

        //"\n".$this->asesor2."  ".$this->asesor5."\n ".$this->asesor3." ".$this->asesor6;

            //"\r\n".$this->asesor4."<br />\n".$this->asesor2."<br />\n".$this->asesor5."<br />\n".$this->asesor3."<br />\n".$this->asesor6;
    }

    /**
     * Set division
     *
     * @param \AppBundle\Entity\Division $division
     *
     * @return PrefullDictamen
     */
    public function setDivision(\AppBundle\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \AppBundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }
}
