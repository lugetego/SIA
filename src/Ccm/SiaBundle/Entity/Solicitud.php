<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




/**
 * @ORM\Entity
 * @ORM\Table(name="solicitud")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\ManyToMany(targetEntity="Academico", inversedBy="solicitudes")
     */
    public $academico;

    /**
     * @var sesion
     * @ORM\ManyToMany(targetEntity="Sesiones", inversedBy="solicitudes")
     */
    private $sesion;

    /**
     * @var string $tipo
     *
     * @ORM\Column(name="tipo", type="string", length=30)
     */
    private $tipo;

    /**
     * @var string $pais
     *
     * @ORM\Column(name="pais", type="string", length=30)
     */
    private $pais;

    /**
     * @var string $ciudad
     *
     * @ORM\Column(name="ciudad", type="string", length=30)
     */
    private $ciudad;

    /**
     * @var string $universidad
     *
     * @ORM\Column(name="universidad", type="string", length=30)
     */
    private $universidad;

    /**
     * @var string $profesor
     *
     * @ORM\Column(name="profesor", type="string", length=30)
     */
    private $profesor;

    /**
     * @var string $actividad
     *
     * @ORM\Column(name="actividad", type="string", length=30)
     */
    private $actividad;

    /**
     * @var string $proposito
     *
     * @ORM\Column(name="proposito", type="string", length=30)
     */
    private $proposito;

    /**
     * @var string $proyecto
     *
     * @ORM\Column(name="proyecto", type="string")
     */
    private $proyecto;

    /**
     * @var string $inicio
     *
     * @ORM\Column(name="inicio", type="date")
     */
    private $inicio;

    /**
     * @var string $fin
     *
     * @ORM\Column(name="fin", type="date")
     */
    private $fin;

    /**
     * @var string $trabajo
     *
     * @ORM\Column(name="trabajo", type="string", length=30)
     */
    private $trabajo;


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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

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
        $this->academico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sesion = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add academico
     *
     * @param \Ccm\SiaBundle\Entity\Academico $academico
     * @return Solicitud
     */
    public function addAcademico(\Ccm\SiaBundle\Entity\Academico $academico)
    {
        $this->academico[] = $academico;

        return $this;
    }

    /**
     * Remove academico
     *
     * @param \Ccm\SiaBundle\Entity\Academico $academico
     */
    public function removeAcademico(\Ccm\SiaBundle\Entity\Academico $academico)
    {
        $this->academico->removeElement($academico);
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
     * Add sesion
     *
     * @param \Ccm\SiaBundle\Entity\Sesiones $sesion
     * @return Solicitud
     */
    public function addSesion(\Ccm\SiaBundle\Entity\Sesiones $sesion)
    {
        $this->sesion[] = $sesion;

        return $this;
    }

    /**
     * Remove sesion
     *
     * @param \Ccm\SiaBundle\Entity\Sesiones $sesion
     */
    public function removeSesion(\Ccm\SiaBundle\Entity\Sesiones $sesion)
    {
        $this->sesion->removeElement($sesion);
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
     * Set proposito
     *
     * @param string $proposito
     * @return Solicitud
     */
    public function setProposito($proposito)
    {
        $this->proposito = $proposito;

        return $this;
    }

    /**
     * Get proposito
     *
     * @return string 
     */
    public function getProposito()
    {
        return $this->proposito;
    }

    /**
     * Set proyecto
     *
     * @param string $proyecto
     * @return Solicitud
     */
    public function setProyecto($proyecto)
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    /**
     * Get proyecto
     *
     * @return string
     */
    public function getProyecto()
    {
        return $this->proyecto;
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

}
