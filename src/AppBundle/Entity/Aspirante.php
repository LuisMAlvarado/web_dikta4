<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Aspirante
 *
 * @ORM\Table(name="aspirante", uniqueConstraints={@ORM\UniqueConstraint(name="RFC_UNIQUE", columns={"rfc"})}, indexes={@ORM\Index(name="fk_aspirante_role1_idx", columns={"role_id"})})
 * @ORM\Entity
 * @DoctrineAssert\UniqueEntity("correoElectronico")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\AspiranteRepository")
 */
class Aspirante implements AdvancedUserInterface, \Serializable
{
    //CAMBIE AL MAYUSCULA OBLIGATIRIOS ALGUNOS ATRIBUTOS
    /**
     * @var string
     *
     * @ORM\Column(name="rfc", type="string", length=13, nullable=false)
     * @ORM\Id
     */
    private $rfc;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     *
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=200, nullable=true)
     */
    private $apellidoPaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_materno", type="string", length=200, nullable=true)
     */
    private $apellidoMaterno;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_economico", type="integer", length=5, nullable=true)
     */
    private $numeroEconomico;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @var string
     *
     * @ORM\Column(name="curp", type="string", length=20, nullable=true)
     */
    private $curp;

    /**
     * @var string
     * @Assert\Email()
     *
     * @ORM\Column(name="correoelectronico", type="string", length=50, nullable=true)
     */
    private $correoElectronico;

    /**
     * @var string
     * @ORM\Column(name="nacionalidad", type="string", length=45, nullable=true)
     */
    private $nacionalidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="edad", type="integer", nullable=false)
     */
    private $edad;

    /**
     * @var \DateTime
     * @Assert\Date()
     * @ORM\Column(name="fechaBirthday", type="date", nullable=true)
     */
    private $fechaBirthday;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=10, nullable=true)
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="estadocivil", type="string", length=20, nullable=true)
     */
    private $estadoCivil;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonos", type="string", length=45, nullable=true)
     */
    private $telefonos;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="text", nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="noext", type="string", length=30, nullable=true)
     */
    private $noExt;

    /**
     * @var string
     *
     * @ORM\Column(name="edif", type="string", length=30, nullable=true)
     */
    private $edif;

    /**
     * @var string
     *
     * @ORM\Column(name="depto", type="string", length=30, nullable=true)
     */
    private $depto;

    /**
     * @var string
     *
     * @ORM\Column(name="coloniafracc", type="text", nullable=true)
     */
    private $coloniaFracc;

    /**
     * @var string
     *
     * @ORM\Column(name="delegMunc", type="text", nullable=true)
     */
    private $delegMunc;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="text", nullable=true)
     */
    private $estado;

    /**
     * @var integer
     *
     * @ORM\Column(name="codPost", type="integer", length=7, nullable=true)
     */
    private $codPost;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enable", type="boolean", nullable=false)
     */
    private $enable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="loked", type="boolean", nullable=false)
     */
    private $loked;

    /**
     * @var integer
     *
     * @ORM\Column(name="expired", type="integer", nullable=false)
     */
    private $expired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ultimaConexion", type="date", nullable=true)
     */
    private $ultimaConexion;

    /**
     * @var \Role
     *
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Archivo", mappedBy="aspiranteRfc")
     * @ORM\OrderBy({"aspiranteRfc" = "ASC"})
     */
    private $archivos;

    /**
     * INICIA LA CREACION DE FUNCIONES PUBLICAS
     *__CONTRUCT Y __TOSTRING
     *
     */

    public function __construct()
    {
        $this ->createAt = new \DateTime('now');
        $this ->loked =false;
        $this ->enable=false;
        $this ->expired=7;
        $this->archivos = new ArrayCollection();
    }

    public function __toString()
    {
return $this->rfc;
    }

    /** aqui se construye los elementos para la interface del usuario
    *public function Username ,salt, password , ROLES y serialize
    */

    public function getUsername()
    {
        return $this->rfc;
    }
    public function getRoles()
    {
        return array($this->role->getRole());
        // return ['ROLE_ASPIRANTE'];
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(

            $this->rfc,
            $this->password,
            //    $this->enable,
            // see section on salt below
            // $this->salt,
        ));
    }


  
    
    
    
    
    
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (

            $this->rfc,
            $this->password,
            //    $this->enable,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    //apartir de aqui es AdvancerInterface
    //NonExpired, NonLocked, CredencialesNonExpired e IsEnable
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return !$this->loked;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->enable;
        //return $this->isActive; ESTO FORZA A SIEMPRE ACTIVO
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     *
     * @return Aspirante
     */
    public function setRfc($rfc)
    {
        $this->rfc = mb_strtoupper($rfc,"UTF-8");

        return $this;
    }

    /**
     * Get rfc
     *
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Aspirante
     */
    public function setNombre($nombre)
    {
        $this->nombre = mb_strtoupper($nombre,"UTF-8");

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

    public function getNombreCompleto()
    {
        return $this->apellidoPaterno." ".$this->apellidoMaterno." ".$this->nombre;
    }


    /**
     * Set apellidoPaterno
     *
     * @param string $apellidoPaterno
     *
     * @return Aspirante
     */
    public function setApellidoPaterno($apellidoPaterno)
    {
        $this->apellidoPaterno = mb_strtoupper($apellidoPaterno,"UTF-8");

        return $this;
    }

    /**
     * Get apellidoPaterno
     *
     * @return string
     */
    public function getApellidoPaterno()
    {
        return $this->apellidoPaterno;
    }

    /**
     * Set apellidoMaterno
     *
     * @param string $apellidoMaterno
     *
     * @return Aspirante
     */
    public function setApellidoMaterno($apellidoMaterno)
    {
        $this->apellidoMaterno = mb_strtoupper($apellidoMaterno,"UTF-8");

        return $this;
    }

    /**
     * Get apellidoMaterno
     *
     * @return string
     */
    public function getApellidoMaterno()
    {
        return $this->apellidoMaterno;
    }

    /**
     * Set numeroEconomico
     *
     * @param integer $numeroEconomico
     *
     * @return Aspirante
     */
    public function setNumeroEconomico($numeroEconomico)
    {
        $this->numeroEconomico = $numeroEconomico;

        return $this;
    }

    /**
     * Get numeroEconomico
     *
     * @return integer
     */
    public function getNumeroEconomico()
    {
        return $this->numeroEconomico;
    }

    /**
     * Set createAt
     *
     * @param \DateTime $createAt
     *
     * @return Aspirante
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * Get createAt
     *
     * @return \DateTime
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * Set curp
     *
     * @param string $curp
     *
     * @return Aspirante
     */
    public function setCurp($curp)
    {
        $this->curp = mb_strtoupper($curp,"UTF-8");

        return $this;
    }

    /**
     * Get curp
     *
     * @return string
     */
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * Set correoElectronico
     *
     * @param string $correoElectronico
     *
     * @return Aspirante
     */
    public function setCorreoElectronico($correoElectronico)
    {
        $this->correoElectronico = $correoElectronico;

        return $this;
    }

    /**
     * Get correoElectronico
     *
     * @return string
     */
    public function getCorreoElectronico()
    {
        return $this->correoElectronico;
    }

    /**
     * Set nacionalidad
     *
     * @param string $nacionalidad
     *
     * @return Aspirante
     */
    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = mb_strtoupper($nacionalidad,"UTF-8");

        return $this;
    }

    /**
     * Get nacionalidad
     *
     * @return string
     */
    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     *
     * @return Aspirante
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     *
     * @return Aspirante
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set estadoCivil
     *
     * @param string $estadoCivil
     *
     * @return Aspirante
     */
    public function setEstadoCivil($estadoCivil)
    {
        $this->estadoCivil = $estadoCivil;

        return $this;
    }

    /**
     * Get estadoCivil
     *
     * @return string
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * Set telefonos
     *
     * @param string $telefonos
     *
     * @return Aspirante
     */
    public function setTelefonos($telefonos)
    {
        $this->telefonos = mb_strtoupper($telefonos,"UTF-8");

        return $this;
    }

    /**
     * Get telefonos
     *
     * @return string
     */
    public function getTelefonos()
    {
        return $this->telefonos;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Aspirante
     */
    public function setDireccion($direccion)
    {
        $this->direccion = mb_strtoupper($direccion,"UTF-8");

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Aspirante
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return Aspirante
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return Aspirante
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return boolean
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Set loked
     *
     * @param boolean $loked
     *
     * @return Aspirante
     */
    public function setLoked($loked)
    {
        $this->loked = $loked;

        return $this;
    }

    /**
     * Get loked
     *
     * @return boolean
     */
    public function getLoked()
    {
        return $this->loked;
    }

    /**
     * Set expired
     *
     * @param integer $expired
     *
     * @return Aspirante
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return integer
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set ultimaConexion
     *
     * @param \DateTime $ultimaConexion
     *
     * @return Aspirante
     */
    public function setUltimaConexion($ultimaConexion)
    {
        $this->ultimaConexion = $ultimaConexion;

        return $this;
    }

    /**
     * Get ultimaConexion
     *
     * @return \DateTime
     */
    public function getUltimaConexion()
    {
        return $this->ultimaConexion;
    }

    /**
     * Set role
     *
     * @param \AppBundle\Entity\Role $role
     *
     * @return Aspirante
     */
    public function setRole(\AppBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \AppBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add archivo
     *
     * @param \AppBundle\Entity\Archivo $archivo
     *
     * @return Aspirante
     */
    public function addArchivo(\AppBundle\Entity\Archivo $archivo)
    {
        $this->archivos[] = $archivo;

        return $this;
    }

    /**
     * Remove archivo
     *
     * @param \AppBundle\Entity\Archivo $archivo
     */
    public function removeArchivo(\AppBundle\Entity\Archivo $archivo)
    {
        $this->archivos->removeElement($archivo);
    }

    /**
     * Get archivos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivos()
    {
        return $this->archivos;
    }

    /**
     * Set calle
     *
     * @param string $calle
     *
     * @return Aspirante
     */
    public function setCalle($calle)
    {
        $this->calle = mb_strtoupper($calle,"UTF-8");

        return $this;
    }

    /**
     * Get calle
     *
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set noExt
     *
     * @param string $noExt
     *
     * @return Aspirante
     */
    public function setNoExt($noExt)
    {
        $this->noExt = mb_strtoupper($noExt,"UTF-8");

        return $this;
    }

    /**
     * Get noExt
     *
     * @return string
     */
    public function getNoExt()
    {
        return $this->noExt;
    }

    /**
     * Set edif
     *
     * @param string $edif
     *
     * @return Aspirante
     */
    public function setEdif($edif)
    {
        $this->edif = mb_strtoupper($edif,"UTF-8");

        return $this;
    }

    /**
     * Get edif
     *
     * @return string
     */
    public function getEdif()
    {
        return $this->edif;
    }

    /**
     * Set depto
     *
     * @param string $depto
     *
     * @return Aspirante
     */
    public function setDepto($depto)
    {
        $this->depto = mb_strtoupper($depto,"UTF-8");

        return $this;
    }

    /**
     * Get depto
     *
     * @return string
     */
    public function getDepto()
    {
        return $this->depto;
    }

    /**
     * Set coloniaFracc
     *
     * @param string $coloniaFracc
     *
     * @return Aspirante
     */
    public function setColoniaFracc($coloniaFracc)
    {
        $this->coloniaFracc = mb_strtoupper($coloniaFracc,"UTF-8");

        return $this;
    }

    /**
     * Get coloniaFracc
     *
     * @return string
     */
    public function getColoniaFracc()
    {
        return $this->coloniaFracc;
    }

    /**
     * Set delegMunc
     *
     * @param string $delegMunc
     *
     * @return Aspirante
     */
    public function setDelegMunc($delegMunc)
    {
        $this->delegMunc = mb_strtoupper($delegMunc,"UTF-8");

        return $this;
    }

    /**
     * Get delegMunc
     *
     * @return string
     */
    public function getDelegMunc()
    {
        return $this->delegMunc;
    }

    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Aspirante
     */
    public function setEstado($estado)
    {
        $this->estado = mb_strtoupper($estado,"UTF-8");

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set codPost
     *
     * @param integer $codPost
     *
     * @return Aspirante
     */
    public function setCodPost($codPost)
    {
        $this->codPost = $codPost;

        return $this;
    }

    /**
     * Get codPost
     *
     * @return integer
     */
    public function getCodPost()
    {
        return $this->codPost;
    }

    /**
     * Set fechaBirthday
     *
     * @param \DateTime $fechaBirthday
     *
     * @return Aspirante
     */
    public function setFechaBirthday($fechaBirthday)
    {
        $this->fechaBirthday = $fechaBirthday;

        return $this;
    }

    /**
     * Get fechaBirthday
     *
     * @return \DateTime
     */
    public function getFechaBirthday()
    {
        return $this->fechaBirthday;
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     * 
     */
    public function validanacionalidad(ExecutionContextInterface $context)
    {
        if ($this->enable == true && $this->nacionalidad == null ){
            $context->buildViolation('Escribe tu NACIONALIDAD')
                ->atPath('nacionalidad')
                ->addViolation();

        }
        
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     *
     */
    public function validacurp(ExecutionContextInterface $context)
    {
        if ($this->enable == true && $this->curp == null ){
            $context->buildViolation('Escribe tu CURP')
                ->atPath('curp')
                ->addViolation();

        }

    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     *
     */
    public function validacalle(ExecutionContextInterface $context)
    {
        if ($this->enable == true && $this->calle == null ){
            $context->buildViolation('Escribe tu CALLE')
                ->atPath('calle')
                ->addViolation();

        }

    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     *
     */
    public function validanumExt(ExecutionContextInterface $context)
    {
        if ($this->enable == true && $this->noExt == null ){
            $context->buildViolation('Escribe tu # Exterior')
                ->atPath('noExt')
                ->addViolation();

        }

    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     *
     */
    public function validaColFrac(ExecutionContextInterface $context)
    {
        if ($this->enable == true && $this->coloniaFracc == null ){
            $context->buildViolation('Escribe tu COL./FRACC.')
                ->atPath('coloniaFracc')
                ->addViolation();

        }

    }

    
}
