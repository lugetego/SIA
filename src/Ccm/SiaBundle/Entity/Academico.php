<?php

namespace Ccm\SiaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Ccm\SiaBundle\Entity\AcademicoRepository")
 * @ORM\Table(name="academico")
 */
class Academico
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    private $name;

    /**
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=120)
     */
    private $apellido;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $nacimiento;

    /**
     * @ORM\Column(type="string", length=13)
     * @Assert\NotBlank()
     */
    protected $rfc;

    /**
     *
     * @ORM\OneToOne(targetEntity="Ccm\SiaBundle\Entity\User", inversedBy="academico")
     */
    private $user;

    /**
     * @var array $solicitudes
     *
     * @ORM\OneToMany(targetEntity="Ccm\SiaBundle\Entity\Solicitud", mappedBy="academico")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;

    /**
     * @var array $proyectos
     *
     * @ORM\ManyToMany(targetEntity="Ccm\SiaBundle\Entity\Proyecto", mappedBy="academico")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $proyectos;

    /**
     * @ORM\Column(type="integer", length=3, nullable=true)
     * @Assert\NotBlank()
     */
    private $dias;

    /**
     * @ORM\Column(type="integer", length=3, nullable=true)
     * @Assert\NotBlank()
     */
    private $asignacion;

    /**
     * @Gedmo\Slug(fields={"apellido", "name"}, )
     * @ORM\Column(length=128, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
//    private $numeroTrabajador;

    /**
     * @ORM\Column(name="categoria", type="string", length=40)
     * @Assert\NotBlank()
     */
//    private $categoria;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
//    protected $fechaContratacion;

    /**
     * @ORM\Column(type="date" nullable=true)
     */
//    protected $fechaDefinitividad;


    /**
     * @ORM\Column(type="date" nullable=true)
     */
//    protected $fechaFechaContratoFin;

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
     * Set name
     *
     * @param string $name
     * @return Academico
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nacimiento
     *
     * @param \DateTime $nacimiento
     * @return Academico
     */
    public function setNacimiento($nacimiento)
    {
        $this->nacimiento = $nacimiento;

        return $this;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Get nacimiento
     *
     * @return \DateTime 
     */
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    /**
     * Set rfc
     *
     * @param string $rfc
     * @return Academico
     */
    public function setRfc($rfc)
    {
        $this->rfc = $rfc;

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
     * @param mixed $dias
     */
    public function setDias($dias)
    {
        $this->dias = $dias;
    }

    /**
     * @return mixed
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * @param mixed $asignacion
     */
    public function setAsignacion($asignacion)
    {
        $this->asignacion = $asignacion;
    }

    /**
     * @return mixed
     */
    public function getAsignacion()
    {
        return $this->asignacion;
    }

    /**
     * Set user
     *
     * @param \Ccm\SiaBundle\Entity\User $user
     * @return Academico
     */
    public function setUser(\Ccm\SiaBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Ccm\SiaBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return $this->name . ' ' . $this->apellido;

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->proyectos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     * @return Academico
     */
    public function addSolicitude(\Ccm\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes[] = $solicitudes;

        return $this;
    }

    /**
     * Remove solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     */
    public function removeSolicitude(\Ccm\SiaBundle\Entity\Solicitud $solicitudes)
    {
        $this->solicitudes->removeElement($solicitudes);
    }

    /**
     * Get solicitudes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

    /**
     * Add proyectos
     *
     * @param \Ccm\SiaBundle\Entity\Proyecto $proyectos
     * @return Academico
     */
    public function addProyecto(\Ccm\SiaBundle\Entity\Proyecto $proyectos)
    {
        $this->proyectos[] = $proyectos;

        return $this;
    }

    /**
     * Remove proyectos
     *
     * @param \Ccm\SiaBundle\Entity\Proyecto $proyectos
     */
    public function removeProyecto(\Ccm\SiaBundle\Entity\Proyecto $proyectos)
    {
        $this->proyectos->removeElement($proyectos);
    }

    /**
     * Get proyectos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

    public function getSlug()
    {
        return $this->slug;
    }

}
