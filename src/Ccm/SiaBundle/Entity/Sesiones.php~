<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="sesiones")
 */
class Sesiones
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $fecha;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    protected $name;

    /**
     * @var array $solicitudes
     *
     * @ORM\OneToMany(targetEntity="Ccm\SiaBundle\Entity\Solicitud", mappedBy="sesion")
*
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Sesiones
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Sesiones
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
     * Add solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     * @return Sesiones
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

    public function __toString()
    {
        return $this->name;
    }
}
