<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="Ccm\SiaBundle\Entity\SolicitudRepository")
 * @ORM\Table(name="solicitud")
 * @ORM\HasLifecycleCallbacks
 * @Vich\Uploadable
 */
class Solicitud
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var academico
     * @ORM\ManyToOne(targetEntity="Academico", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="academico_id", referencedColumnName="id")
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $academico;


    /**
     * @var sesion
     * @ORM\ManyToOne(targetEntity="Sesiones", inversedBy="solicitudes")
     * @ORM\JoinColumn(name="sesion_id", referencedColumnName="id", nullable=true)
     * Assert NotBlank(groups={"solicitud","visitante"})
     */
    private $sesion;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=10)
     * @Assert\Choice(choices = {"licencia", "comision"}, message = "Choose a valid option.")
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $tipo;

    /**
     * @var string $pais
     *
     * @ORM\Column(name="pais", type="string", length=30, nullable=true)
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $pais;

    /**
     * @var string $ciudad
     *
     * @ORM\Column(name="ciudad", type="string", length=30, nullable=true)
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $ciudad;

    /**
     * @var string $estado
     *
     * @ORM\Column(name="estado", type="string", length=30, nullable=true)
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $estado;

    /**
     * @var string $universidad
     *
     * @ORM\Column(name="universidad", type="string", length=150, nullable=true)
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $universidad;

    /**
     * @var string $profesor
     *
     * @ORM\Column(name="profesor", type="string", length=50, nullable=true)
     * @Assert\NotBlank(groups={"visitante"})
     */
    private $profesor;

    /**
     * @var string $actividad
     *
     * @ORM\Column(name="actividad", type="string", length=1000, nullable=true)
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $actividad;

    /**
     * @var array $propositos
     *
     * @ORM\Column(name="propositos", type="simple_array", nullable=true)
     * @Assert\NotBlank(groups={"solicitud"})
     */
    private $propositos;

     /**
     * @var proyecto
     * (Owning side)
     * @ORM\ManyToOne(targetEntity="Proyecto", inversedBy="solicitudes")
     * ORM JoinColumn(name="proyecto_id", referencedColumnName="id", nullable=true)
     * Assert NotBlank(groups={"solicitud","visitante"})
     */
    // private $proyecto;

    /**
     * @var string $inicio
     *
     * @ORM\Column(name="inicio", type="date", nullable=true)
     * @Assert\Date()
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $inicio;

    /**
     * @var string $fin
     *
     * @ORM\Column(name="fin", type="date", nullable=true)
     * @Assert\Date()
     * @Assert\NotBlank(groups={"solicitud","visitante"})
     */
    private $fin;

    /**
     * @var string $trabajo
     *
     * @ORM\Column(name="trabajo", type="string", length=500, nullable=true)
     */
    private $trabajo;

    /**
     * @var string $observaciones
     *q
     * @ORM\Column(name="observaciones", type="string", length=1000, nullable=true)
     */
    private $observaciones;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $financiamiento;

    /**
     * @var boolean $enviada
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enviada;

   /**
     * @var boolean $aprobada
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aprobada;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="solicitud_carta_invitacion", fileNameProperty="cartaInvitacionName")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "6M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     * @Assert\NotBlank(message = "La carta de invitación es requerida para una solicitud de comisión", groups={"comision"})
     */
    private $cartaInvitacionFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $cartaInvitacionName;

    /**
     * @Vich\UploadableField(mapping="solicitud_plan_trabajo", fileNameProperty="planTrabajoName")
     *
     * @var File
     * @Assert\File(
     *     maxSize = "6M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     * @Assert\NotBlank(message = "El plan de trabajo es requerid para una solicitud de comisión", groups={"comision"})
     */
    private $planTrabajoFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     *
     */
    private $planTrabajoName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $notificada;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modified;

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setCreated(new \DateTime());
        $this->setModified(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setModified(new \DateTime());

    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;

    }

    /**
     * Set modified
     *
     * @param datetime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * Get modified
     *
     * @return string
     */
    public function getModified()
    {
        return $this->modified;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->financiamiento = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set academico
     *
     * @param \Ccm\SiaBundle\Entity\academico $academico
     */
    public function setAcademico($academico)
    {
        $this->academico = $academico;
    }

    /**
     * Get academico
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcademico()
    {
        return $this->academico;
    }



    /**
     * Get sesion
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSesion()
    {
        return $this->sesion;
    }

    /**
     * Set sesion
     *
     * @param string $sesion
     */
    public function setSesion($sesion)
    {
        $this->sesion = $sesion;
    }



    /**
    * Set tipo
     *
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function __toString()
    {
        return $this->tipo;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Solicitud
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Solicitud
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string 
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set universidad
     *
     * @param string $universidad
     * @return Solicitud
     */
    public function setUniversidad($universidad)
    {
        $this->universidad = $universidad;

        return $this;
    }

    /**
     * Get universidad
     *
     * @return string 
     */
    public function getUniversidad()
    {
        return $this->universidad;
    }

    /**
     * Set profesor
     *
     * @param string $profesor
     * @return Solicitud
     */
    public function setProfesor($profesor)
    {
        $this->profesor = $profesor;

        return $this;
    }

    /**
     * Get profesor
     *
     * @return string 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set actividad
     *
     * @param string $actividad
     * @return Solicitud
     */
    public function setActividad($actividad)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return string 
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set propositos
     *
     * @param array $propositos
     * @return Propositos
     */
    public function setPropositos(array $propositos)
    {
        $this->propositos = $propositos;

        return $this;
    }

    /**
     * Get propositos
     *
     * @return array
     */
    public function getPropositos()
    {
        return $this->propositos;
    }


   /**
     * Set proyecto
     *
     * @param array $proyecto
     * @return Solicitud
     */
    /*    public function setProyecto($proyecto)
        {
            $this->proyecto = $proyecto;

            return $this;
        }

        /**
         * Get proyecto
         *
         * @return string
         */
    /*
    public function getProyecto()
    {
        return $this->proyecto;
    }
*/

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * Set inicio
     *
     * @param \DateTime $inicio
     * @return Solicitud
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return \DateTime 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Solicitud
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set trabajo
     *
     * @param string $trabajo
     * @return Solicitud
     */
    public function setTrabajo($trabajo)
    {
        $this->trabajo = $trabajo;

        return $this;
    }

    /**
     * Get trabajo
     *
     * @return string 
     */
    public function getTrabajo()
    {
        return $this->trabajo;
    }

    /**
     * Get financiamiento
     *
     * @return array 
     */
    public function getFinanciamiento()
    {
        return $this->financiamiento;
    }

    /**
     * Set financiamiento
     *
     * @param array
     */
    public function setFinanciamiento($financiamiento)
    {
        $this->financiamiento = $financiamiento;
    }

    /**
     * @param boolean $enviada
     */
    public function setEnviada($enviada)
    {
        $this->enviada = $enviada;
    }

    /**
     * @return boolean
     */
    public function getEnviada()
    {
        return $this->enviada;
    }

    /**
     * @param boolean $aprobada
     */
    public function setAprobada($aprobada)
    {
        $this->aprobada = $aprobada;
    }

    /**
     * @return boolean
     */
    public function getAprobada()
    {
        return $this->aprobada;
    }

    public function isDatesValid()
    {
        if($this->inicio < $this->fin ){

            $interval = $this->inicio->diff($this->fin);
            return $interval->days <= 45;
        }
        else {
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getNotificada()
    {
        return $this->notificada;
    }

    /**
     * @param mixed $notificada
     */
    public function setNotificada($notificada)
    {
        $this->notificada = $notificada;
    }

    /**
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    // -----------------------------------------------------------------------------------------------------------------
    // File upload Carta Invitacion
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cartaInvitacion
     */
    public function setCartaInvitacionFile(File $cartaInvitacion = null)
    {
        $this->cartaInvitacionFile = $cartaInvitacion;

        if ($cartaInvitacion) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getCartaInvitacionFile()
    {
        return $this->cartaInvitacionFile;
    }

    /**
     * @param string $cartaInvitacionName
     */
    public function setCartaInvitacionName($cartaInvitacionName)
    {
        $this->cartaInvitacionName = $cartaInvitacionName;
    }

    /**
     * @return string
     */
    public function getCartaInvitacionName()
    {
        return $this->cartaInvitacionName;
    }

    // File upload Plan de Trabajo
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $planTrabajo
     */
    public function setPlanTrabajoFile(File $planTrabajo = null)
    {
        $this->planTrabajoFile = $planTrabajo;

        if ($planTrabajo) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->modified = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getPlanTrabajoFile()
    {
        return $this->planTrabajoFile;
    }

    /**
     * @param string $planTrabajoName
     */
    public function setPlanTrabajoName($planTrabajoName)
    {
        $this->planTrabajoName = $planTrabajoName;
    }

    /**
     * @return string
     */
    public function getPlanTrabajoName()
    {
        return $this->planTrabajoName;
    }

    // -----------------------------------------------------------------------------------------------------------------
    /**
     * @return suma financiamiento CCM
     */
    public function getTotalAsignación()
    {
        $total_asignacion = 0;

        foreach ($this->financiamiento as $finccm)
            $total_asignacion += $finccm->getCcm();

        return $total_asignacion;
    }

    /**
     * @return Total de días solicitados
     */
    public function getDias()
    {

//    $datetime1 = new DateTime('2009-10-11');
//    $datetime2 = new DateTime('2009-10-13');
//    $interval = $datetime1->diff($datetime2);
//    echo $interval->format('%R%a days');

        $dias = $this->fin->diff($this->inicio);

        return $dias->format('%d') + 1;
    }

}
