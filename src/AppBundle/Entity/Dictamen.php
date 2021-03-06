<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Dictamen
 *
 * @ORM\Table(name="dictamen")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\DictamenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Dictamen
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="numdictamen", type="string", length=21, nullable=false)
     */
    private $numDictamen;

    /**
     * @ORM\OneToOne(targetEntity="Concurso", mappedBy="dictamen")
     */
    private $concurso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechadictmen", type="datetime", nullable=false)
     */
    private $fechaDictmen;

    /**
     * @var string
     *
     * @ORM\Column(name="nivelasignado", type="string", length=45, nullable=true)
     */
    private $nivelAsignado;

    /**
     * @var string
     *
     * @ORM\Column(name="modalidades", type="text", nullable=false)
     */
    private $modalidades;

    /**
     * @var string
     *
     * @ORM\Column(name="arguemento", type="text", nullable=false)
     */
    private $argumento;

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
     * @var string
     *
     * @ORM\Column(name="presidente", type="text", nullable=true)
     */
    private $presidente;

    /**
     * @var string
     *
     * @ORM\Column(name="secretario", type="text", nullable=true)
     */
    private $secretario;

    /**
     * @var string
     *
     * @ORM\Column(name="pdfdictamen", type="string", length=255, nullable=true)
     */
    private $pdfDictamen;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    /**
     * AQUI ESTOY GENERANDO LAS FUNCIONES PUBLICAS
     */

    public function __toString()
    {
        //return $this->numDictamen;
        return strval($this->id);
    }

    public function __construct()
    {
        $this->fechaDictmen = new \DateTime('now');
        

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
     * Set numDictamen
     *
     * @param string $numDictamen
     *
     * @return Dictamen
     */
    public function setNumDictamen($numDictamen)
    {
        $this->numDictamen = $numDictamen;

        return $this;
    }

    /**
     * Get numDictamen
     *
     * @return string
     */
    public function getNumDictamen()
    {
        return $this->numDictamen;
    }

    /**
     * Set fechaDictmen
     *
     * @param \DateTime $fechaDictmen
     *
     * @return Dictamen
     */
    public function setFechaDictmen($fechaDictmen)
    {
        $this->fechaDictmen = $fechaDictmen;

        return $this;
    }

    /**
     * Get fechaDictmen
     *
     * @return \DateTime
     */
    public function getFechaDictmen()
    {
        return $this->fechaDictmen;
    }

    /**
     * Set nivelAsignado
     *
     * @param string $nivelAsignado
     *
     * @return Dictamen
     */
    public function setNivelAsignado($nivelAsignado)
    {
        $this->nivelAsignado = $nivelAsignado;

        return $this;
    }

    /**
     * Get nivelAsignado
     *
     * @return string
     */
    public function getNivelAsignado()
    {
        return $this->nivelAsignado;
    }

    /**
     * Set modalidades
     *
     * @param string $modalidades
     *
     * @return Dictamen
     */
    public function setModalidades($modalidades)
    {
        $this->modalidades = $modalidades;

        return $this;
    }

    /**
     * Get modalidades
     *
     * @return string
     */
    public function getModalidades()
    {
        return $this->modalidades;
    }

    /**
     * Set argumento
     *
     * @param string $argumento
     *
     * @return Dictamen
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
     * Set pdfDictamen
     *
     * @param string $pdfDictamen
     *
     * @return Dictamen
     */
    public function setPdfDictamen($pdfDictamen)
    {
        $this->pdfDictamen = $pdfDictamen;

        return $this;
    }

    /**
     * Get pdfDictamen
     *
     * @return string
     */
    public function getPdfDictamen()
    {
        return $this->pdfDictamen;
    }

    /**
     * Set concurso
     *
     * @param \AppBundle\Entity\Concurso $concurso
     *
     * @return Dictamen
     */
    public function setConcurso(\AppBundle\Entity\Concurso $concurso = null)
    {
        $this->concurso = $concurso;

        return $this;
    }

    /**
     * Get concurso
     *
     * @return \AppBundle\Entity\Concurso
     */
    public function getConcurso()
    {
        return $this->concurso;
    }

    /**
     * @Assert\Callback
     */

    /** COMENTE LA VALIDACION PARA AFINAR POSTERIORMENTE EL LLENADO  3 DE NOVIEMBRE 2017
    public function validaGanador(ExecutionContextInterface $context){
        $prelacionMin = null;
        foreach($this->concurso->getRegistros() as $registro)
        {

           // if (!empty($prelacionMin= $registro->getPrelacion()) or ($prelacionMin == 0) ){
           //     $prelacionMin = $registro->getPrelacion();
           // }



        if($registro->getPrelacion() !== null && ( $prelacionMin == null ||$prelacionMin > $registro->getPrelacion())){
            $prelacionMin = $registro->getPrelacion();
            //(dump($registro);
            }


        } //exit();

        //dump($prelacionMin,$registro); exit();

        if($prelacionMin != null && $prelacionMin > 0){
            // Hay prelados pero no hay ganador
            $context->buildViolation('Debe asignar un Ganador (Prelado 0)!')
                ->atPath('nivelAsignado')
                ->addViolation();
        }
    }
     // TERMINA VALIDACION COMENTADA 3 DE NOVIEMBRE
     */


    /**
     * @Assert\Callback
     */
    public function validaNoRep(ExecutionContextInterface $context){
        $countPrelaciones = array();
        foreach($this->concurso->getRegistros() as $registro)
        {
            if($registro->getPrelacion() !== null)
            {
                if(isset($countPrelaciones[$registro->getPrelacion()])) {
                    $countPrelaciones[$registro->getPrelacion()]++;
                }else{
                    $countPrelaciones[$registro->getPrelacion()] = 1;
                }

            }
        }
        //dump($countPrelaciones); exit();

        foreach ($countPrelaciones as $prelacion => $contador)
        {
            if($contador > 1 ){
                $context->buildViolation('Asigno a mas de un aspirante la prelacion ' . $prelacion)
                    ->atPath('nivelAsignado')
                    ->addViolation();
            }
        }

    }

    /**
     * Set presidente
     *
     * @param string $presidente
     *
     * @return Dictamen
     */
    public function setPresidente($presidente)
    {
        $this->presidente = $presidente;

        return $this;
    }

    /**
     * Get presidente
     *
     * @return string
     */
    public function getPresidente()
    {
        return $this->presidente;
    }

    /**
     * Set secretario
     *
     * @param string $secretario
     *
     * @return Dictamen
     */
    public function setSecretario($secretario)
    {
        $this->secretario = $secretario;

        return $this;
    }

    /**
     * Get secretario
     *
     * @return string
     */
    public function getSecretario()
    {
        return $this->secretario;
    }

    /**
     * Set asesor1
     *
     * @param string $asesor1
     *
     * @return Dictamen
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
     * @return Dictamen
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
     * @return Dictamen
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
     * @return Dictamen
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
     * @return Dictamen
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
     * @return Dictamen
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
}
