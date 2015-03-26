<?php

namespace Ccm\SiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="proyecto")
 * @ORM\HasLifecycleCallbacks
 */
class Proyecto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string $numero
     *
     * @ORM\Column(name="numero", type="string", length=20)
     */
    private $numero;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=30)
     */
    private $nombre;

    /**
     * @var academico
     * @ORM\ManyToMany(targetEntity="Academico", inversedBy="proyectos")
     */
    private $academico;

    /**
     * @var solicitudes
     * (Inverse side)
     * @ORM\OneToMany(targetEntity="Solicitud", mappedBy="proyecto")
     */
    private $solicitudes;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
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
     * Constructor
     */
    public function __construct()
    {
        $this->academico = new \Doctrine\Common\Collections\ArrayCollection();
        $this->solicitudes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }

    /**
     * Add solicitudes
     *
     * @param \Ccm\SiaBundle\Entity\Solicitud $solicitudes
     * @return Proyecto
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
        return $this->numero . '-' . $this->solicitudes;
    }
}
