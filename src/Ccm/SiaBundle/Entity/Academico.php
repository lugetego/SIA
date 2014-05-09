<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $nacimiento;

    /**
     * @ORM\Column(type="string", length=10)
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
     * @ORM\ManyToMany(targetEntity="Ccm\SiaBundle\Entity\Solicitud", mappedBy="academico")
     *
     * The mappedBy attribute designates the field in the entity that is the owner of the relationship.
     */
    private $solicitudes;




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
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
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
}
